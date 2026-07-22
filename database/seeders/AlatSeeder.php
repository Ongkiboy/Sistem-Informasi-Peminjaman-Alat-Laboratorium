<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $alat = [
            [
                'nama_alat'         => 'Mikroskop Binokuler',
                'kode_barang'       => 'MKR-001',
                'deskripsi'         => 'Mikroskop optik dua lensa untuk pengamatan sel dan jaringan.',
                'stok_baik'         => 5,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 5,
            ],
            [
                'nama_alat'         => 'Oscilloscope Digital',
                'kode_barang'       => 'OSC-001',
                'deskripsi'         => 'Oscilloscope digital 100MHz untuk analisis sinyal listrik.',
                'stok_baik'         => 3,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 3,
            ],
            [
                'nama_alat'         => 'Multimeter Analog',
                'kode_barang'       => 'MLT-001',
                'deskripsi'         => 'Multimeter untuk mengukur tegangan, arus, dan resistansi.',
                'stok_baik'         => 10,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 10,
            ],
            [
                'nama_alat'         => 'Power Supply DC',
                'kode_barang'       => 'PSU-001',
                'deskripsi'         => 'Power supply 0–30V, 0–5A untuk rangkaian elektronika.',
                'stok_baik'         => 8,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 8,
            ],
            [
                'nama_alat'         => 'Function Generator',
                'kode_barang'       => 'FGN-001',
                'deskripsi'         => 'Generator sinyal sine, square, triangle 1Hz–1MHz.',
                'stok_baik'         => 4,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 4,
            ],
            [
                'nama_alat'         => 'Breadboard + Jumper Set',
                'kode_barang'       => 'BRD-001',
                'deskripsi'         => 'Papan prototipe 830 lubang dengan set kabel jumper.',
                'stok_baik'         => 20,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 20,
            ],
            [
                'nama_alat'         => 'Solder Station',
                'kode_barang'       => 'SLD-001',
                'deskripsi'         => 'Solder station digital dengan pengatur suhu 200–480°C.',
                'stok_baik'         => 6,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 6,
            ],
            [
                'nama_alat'         => 'Logic Analyzer',
                'kode_barang'       => 'LGA-001',
                'deskripsi'         => 'Logic analyzer 8 channel untuk debugging protokol digital.',
                'stok_baik'         => 0,
                'stok_rusak_ringan' => 2,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 0,
            ],
            [
                'nama_alat'         => 'Arduino Uno Kit',
                'kode_barang'       => 'ARD-001',
                'deskripsi'         => 'Kit Arduino Uno R3 lengkap dengan sensor dan komponen dasar.',
                'stok_baik'         => 15,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 15,
            ],
            [
                'nama_alat'         => 'Raspberry Pi 4',
                'kode_barang'       => 'RPI-001',
                'deskripsi'         => 'Raspberry Pi 4 Model B 4GB RAM untuk proyek embedded.',
                'stok_baik'         => 5,
                'stok_rusak_ringan' => 0,
                'stok_rusak_berat'  => 0,
                'stok_tersedia'     => 5,
            ],
        ];

        foreach ($alat as $data) {
            Alat::create($data);
        }
    }
}
