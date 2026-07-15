<?php

use App\Models\Pengguna;

it('menghasilkan token dengan kredensial valid', function () {
    $pengguna = Pengguna::factory()->create([
        'email'    => 'test@siplab.dev',
        'password' => bcrypt('password'),
        'role'     => 'mahasiswa',
    ]);

    $response = $this->postJson('/api/v1/token', [
        'email'    => 'test@siplab.dev',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['token', 'tipe']);
});

it('menolak kredensial yang tidak valid', function () {
    Pengguna::factory()->create(['email' => 'test@siplab.dev']);

    $response = $this->postJson('/api/v1/token', [
        'email'    => 'test@siplab.dev',
        'password' => 'salah',
    ]);

    $response->assertStatus(422);
});