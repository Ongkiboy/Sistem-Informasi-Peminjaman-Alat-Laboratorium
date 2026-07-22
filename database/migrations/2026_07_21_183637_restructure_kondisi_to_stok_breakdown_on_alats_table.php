<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            $table->unsignedBigInteger('stok_baik')->default(0)->after('deskripsi');
            $table->unsignedBigInteger('stok_rusak_ringan')->default(0)->after('stok_baik');
            $table->unsignedBigInteger('stok_rusak_berat')->default(0)->after('stok_rusak_ringan');
        });

        // Backfill: seluruh total_stok lama dipindah ke bucket sesuai kondisi lama.
        foreach (['baik', 'rusak_ringan', 'rusak_berat'] as $kondisi) {
            DB::table('alats')
                ->where('kondisi', $kondisi)
                ->update(["stok_{$kondisi}" => DB::raw('total_stok')]);
        }

        // Data lama tidak pernah membatasi stok_tersedia ke unit kondisi baik saja —
        // clamp sekarang supaya konsisten dengan invarian baru (stok_tersedia <= stok_baik).
        DB::table('alats')->update([
            'stok_tersedia' => DB::raw('LEAST(stok_tersedia, stok_baik)'),
        ]);

        Schema::table('alats', function (Blueprint $table) {
            $table->dropColumn(['kondisi', 'total_stok']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik')->after('deskripsi');
            $table->unsignedBigInteger('total_stok')->default(1)->after('kondisi');
        });

        // Best-effort: total_stok = jumlah 3 bucket, kondisi = bucket terbesar.
        DB::table('alats')->update([
            'total_stok' => DB::raw('stok_baik + stok_rusak_ringan + stok_rusak_berat'),
        ]);

        DB::table('alats')->where('stok_rusak_ringan', '>', DB::raw('stok_baik'))
            ->where('stok_rusak_ringan', '>=', DB::raw('stok_rusak_berat'))
            ->update(['kondisi' => 'rusak_ringan']);

        DB::table('alats')->where('stok_rusak_berat', '>', DB::raw('stok_baik'))
            ->where('stok_rusak_berat', '>', DB::raw('stok_rusak_ringan'))
            ->update(['kondisi' => 'rusak_berat']);

        Schema::table('alats', function (Blueprint $table) {
            $table->dropColumn(['stok_baik', 'stok_rusak_ringan', 'stok_rusak_berat']);
        });
    }
};
