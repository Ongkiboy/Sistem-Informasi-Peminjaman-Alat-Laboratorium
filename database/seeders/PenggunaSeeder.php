<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        Pengguna::create([
            'nama'     => 'Administrator Lab',
            'email'    => 'admin@siplab.dev',
            'password' => 'password',
            'nim'      => null,
            'role'     => 'admin',
        ]);

        // Mahasiswa
        $mahasiswa = [
            ['nama' => 'Budi Santoso',   'email' => 'mhs1@siplab.dev', 'nim' => '2021000001'],
            ['nama' => 'Citra Dewi',     'email' => 'mhs2@siplab.dev', 'nim' => '2021000002'],
            ['nama' => 'Dani Pratama',   'email' => 'mhs3@siplab.dev', 'nim' => '2021000003'],
            ['nama' => 'Eka Rahayu',     'email' => 'mhs4@siplab.dev', 'nim' => '2021000004'],
            ['nama' => 'Fajar Nugroho',  'email' => 'mhs5@siplab.dev', 'nim' => '2021000005'],
        ];

        foreach ($mahasiswa as $data) {
            Pengguna::create([
                'nama'     => $data['nama'],
                'email'    => $data['email'],
                'password' => 'password',
                'nim'      => $data['nim'],
                'role'     => 'mahasiswa',
            ]);
        }

    }
}
