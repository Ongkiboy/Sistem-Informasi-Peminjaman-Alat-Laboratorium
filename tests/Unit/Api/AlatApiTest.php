<?php

use App\Models\Alat;
use App\Models\Pengguna;

it('mengembalikan daftar alat tanpa autentikasi', function () {
    Alat::factory()->count(5)->create();

    $response = $this->getJson('/api/v1/alat');

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'data' => [
                     '*' => [
                         'id',
                         'nama_alat',
                         'kode_barang',
                         'kondisi',
                         'stok_tersedia',
                     ]
                 ],
                 'meta',
                 'links',
             ]);
});

it('mendukung pencarian alat via query param q', function () {
    Alat::factory()->create(['nama_alat' => 'Oscilloscope Digital']);
    Alat::factory()->create(['nama_alat' => 'Multimeter Analog']);

    $response = $this->getJson('/api/v1/alat?q=Oscilloscope');

    $response->assertStatus(200)
             ->assertJsonCount(1, 'data');
});