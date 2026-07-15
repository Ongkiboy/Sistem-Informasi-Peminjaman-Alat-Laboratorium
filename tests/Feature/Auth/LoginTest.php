<?php

use App\Models\Pengguna;

it('admin berhasil login dan diarahkan ke dashboard', function () {
    $admin = Pengguna::factory()->create([
        'role'     => 'admin',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login.proses'), [
        'email'    => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

it('mahasiswa berhasil login dan diarahkan ke katalog', function () {
    $mahasiswa = Pengguna::factory()->create([
        'role'     => 'mahasiswa',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login.proses'), [
        'email'    => $mahasiswa->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('mahasiswa.katalog'));
});

it('login gagal dengan password salah', function () {
    $pengguna = Pengguna::factory()->create(['password' => bcrypt('password')]);

    $response = $this->post(route('login.proses'), [
        'email'    => $pengguna->email,
        'password' => 'salah_password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});