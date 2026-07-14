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
        return [
            
            'nama_alat' => faker()->word(3, true),
            'kode_barang' => fake()->unique(),
            'deskripsi' => fake()->sentence(),
            'kondisi' => fake()->randomElement(['baik','rusak_ringan','rusak_berat']),
            'total_stok' => fake()->numberBetween(1, 50),
            'stok_tersedia' => fake()->numberBetween(1, 50)

        ];
    }
}
