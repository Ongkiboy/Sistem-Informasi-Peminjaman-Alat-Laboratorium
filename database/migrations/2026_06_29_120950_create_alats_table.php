<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('kode_barang')->unique();
            $table->text('deskripsi')->nullable();
            $table->enum('kondisi',['baik','rusak_ringan','rusak_berat'])->default('baik');
            $table->unsignedBigInteger('total_stok')->default(1);
            $table->unsignedBigInteger('stok_tersedia')->default(1);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
