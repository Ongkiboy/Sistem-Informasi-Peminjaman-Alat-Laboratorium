<?php

namespace Database\Factories;

use App\Models\Alat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alat>
 */
class AlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stokBaik = fake()->numberBetween(1, 30);

        return [
            'nama_alat'         => fake()->words(3, true),
            'kode_barang'       => strtoupper(fake()->unique()->bothify('???-###')),
            'deskripsi'         => fake()->sentence(),
            'stok_baik'         => $stokBaik,
            'stok_rusak_ringan' => fake()->numberBetween(0, 5),
            'stok_rusak_berat'  => fake()->numberBetween(0, 3),
            'stok_tersedia'     => fake()->numberBetween(0, $stokBaik),
        ];
    }
}
