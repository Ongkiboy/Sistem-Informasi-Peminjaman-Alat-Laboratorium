<?php

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;

// Ukur waktu eksekusi (ms) dan jumlah query DB untuk 1 request — dipakai
// untuk deteksi N+1 query dan regresi lambat di halaman-halaman utama.
// Catatan: waktu di sini murni waktu proses Laravel (in-process, tanpa
// overhead HTTP/OPcache asli) — untuk itu threshold di-set generous (500ms),
// fokus utama justru di jumlah query (indikator N+1 paling akurat & stabil).
function ukurPerforma(Closure $request): array
{
    DB::flushQueryLog();
    DB::enableQueryLog();

    $mulai = microtime(true);
    $response = $request();
    $durasiMs = (microtime(true) - $mulai) * 1000;

    $jumlahQuery = count(DB::getQueryLog());
    DB::disableQueryLog();

    return [$response, $durasiMs, $jumlahQuery];
}

beforeEach(function () {
    // Dataset realistis (bukan 1-2 baris) biar N+1 query kelihatan kalau ada.
    Alat::factory()->count(30)->create();

    $mahasiswaLain = Pengguna::factory()->count(5)->create(['role' => 'mahasiswa']);
    foreach ($mahasiswaLain as $m) {
        Peminjaman::factory()->count(3)->create([
            'pengguna_id' => $m->id,
            'alat_id'     => Alat::inRandomOrder()->first()->id,
        ]);
    }
});

it('halaman login load cepat dengan query minimal', function () {
    [$response, $ms, $query] = ukurPerforma(fn () => $this->get(route('login')));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "Login load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(5, "Login pakai {$query} query — cek ada query tak perlu.");
});

it('dashboard admin load cepat dengan query minimal', function () {
    $admin = Pengguna::factory()->create(['role' => 'admin']);

    [$response, $ms, $query] = ukurPerforma(fn () => $this->actingAs($admin)->get(route('admin.dashboard')));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "Dashboard load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(10, "Dashboard pakai {$query} query — cek ada N+1.");
});

it('indeks alat admin load cepat dan tidak N+1 walau banyak baris', function () {
    $admin = Pengguna::factory()->create(['role' => 'admin']);

    [$response, $ms, $query] = ukurPerforma(fn () => $this->actingAs($admin)->get(route('admin.alat.indeks')));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "Indeks alat load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(6, "Indeks alat pakai {$query} query untuk 30 baris — indikasi N+1.");
});

it('approval admin load cepat dan tidak N+1 walau banyak pengajuan', function () {
    $admin = Pengguna::factory()->create(['role' => 'admin']);

    [$response, $ms, $query] = ukurPerforma(fn () => $this->actingAs($admin)->get(route('admin.approval.indeks')));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "Approval load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(10, "Approval pakai {$query} query — indikasi N+1 (pengguna/alat harus eager loaded).");
});

it('katalog mahasiswa load cepat dan tidak N+1 walau banyak alat', function () {
    $mahasiswa = Pengguna::factory()->create(['role' => 'mahasiswa']);

    [$response, $ms, $query] = ukurPerforma(fn () => $this->actingAs($mahasiswa)->get(route('mahasiswa.katalog')));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "Katalog load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(6, "Katalog pakai {$query} query untuk 30 alat/halaman — indikasi N+1.");
});

it('riwayat mahasiswa load cepat dan tidak N+1', function () {
    $mahasiswa = Pengguna::factory()->create(['role' => 'mahasiswa']);
    Peminjaman::factory()->count(8)->create([
        'pengguna_id' => $mahasiswa->id,
        'alat_id'     => Alat::inRandomOrder()->first()->id,
    ]);

    [$response, $ms, $query] = ukurPerforma(fn () => $this->actingAs($mahasiswa)->get(route('mahasiswa.riwayat')));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "Riwayat load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(6, "Riwayat pakai {$query} query — indikasi N+1.");
});

it('API katalog alat publik load cepat dan tidak N+1', function () {
    [$response, $ms, $query] = ukurPerforma(fn () => $this->getJson('/api/v1/alat'));

    $response->assertOk();
    expect($ms)->toBeLessThan(500, "API alat load {$ms}ms — terlalu lambat.");
    expect($query)->toBeLessThanOrEqual(5, "API alat pakai {$query} query — indikasi N+1.");
});
