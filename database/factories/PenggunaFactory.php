<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected static ?int $sequenceNumber = null;
    protected static ?string $password;

    public function definition(): array
    {
        $tahun = date('y');
        if (static::$sequenceNumber === null){

            $lastMahasiswa = Pengguna::where('nim', 'like', $tahun . '%')
            ->orderBy('nim', 'desc')
            ->first();
            
            if ($lastMahasiswa) {
                $lastSequence = (int) Substr($lastMahasiswa->nim, 2);
                static::$sequenceNumber = $lastSequence + 1;
            } else {
                    static::$sequenceNumber = 0100000;
                }
        }
        $nomorUnik = str_pad(static::$sequenceNumber, 7, '0', STR_PAD_LEFT);
        $nim = $tahun . $nomorUnik;
        static::$sequenceNumber++;

        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'nim'=> $nim, 
            'remember_token' => Str::random(10),
        ];
    }
}
