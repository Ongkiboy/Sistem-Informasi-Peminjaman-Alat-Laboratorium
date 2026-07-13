<?php

use App\Models\Pengguna;

it('mahasiswa tidak bisa akses route admin dan mendapat 403', function () {
    $mahasiswa = Pengguna::factory()->create(['role' => 'mahasiswa']);

    $response = $this->actingAs($mahasiswa)
                     ->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

it('guest di-redirect ke login saat akses route mahasiswa', function () {
    $response = $this->get(route('mahasiswa.katalog'));

    $response->assertRedirect(route('login'));
});

it('admin tidak bisa akses route mahasiswa dan mendapat 403', function () {
    $admin = Pengguna::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
                     ->get(route('mahasiswa.katalog'));

    $response->assertStatus(403);
});