<?php

namespace Database\Factories;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pengguna_id'             => Pengguna::factory()->state(['role' => 'mahasiswa']),
            'alat_id'                 => Alat::factory(),
            'jumlah'                  => fake()->numberBetween(1, 3),
            'tanggal_pinjam'          => now()->addDay()->format('Y-m-d'),
            'tanggal_rencana_kembali' => now()->addDays(3)->format('Y-m-d'),
            'status'                  => 'pending',
        ];
    }
}
