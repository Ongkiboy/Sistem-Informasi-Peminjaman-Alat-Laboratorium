<?php

namespace Database\Factories;

use App\Models\alat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<alat>
 */
class alatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalStok = fake()->numberBetween(1, 50);

        return [
            'nama_alat'     => fake()->words(3, true),
            'kode_barang'   => strtoupper(fake()->unique()->bothify('???-###')),
            'deskripsi'     => fake()->sentence(),
            'kondisi'       => fake()->randomElement(['baik', 'rusak_ringan', 'rusak_berat']),
            'total_stok'    => $totalStok,
            'stok_tersedia' => fake()->numberBetween(0, $totalStok),
        ];
    }
}
