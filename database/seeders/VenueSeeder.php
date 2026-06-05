<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        Venue::create([
            'nama_venue' => 'Auditorium Gd. K',
            'gedung' => 'Gedung K',
            'kapasitas' => 500,
            'fasilitas' => 'AC, Sound System, Proyektor Besar',
            'provinsi_id' => '32',
            'kota_id' => '3204',
            'kecamatan_id' => '3204050'
        ]);

        Venue::create([
            'nama_venue' => 'Lab Komputer Dasar',
            'gedung' => 'Gedung Tokong Nanas',
            'kapasitas' => 40,
            'fasilitas' => '40 PC, AC, Whiteboard',
            'provinsi_id' => '32',
            'kota_id' => '3204',
            'kecamatan_id' => '3204050'
        ]);

        Venue::create([
            'nama_venue' => 'Ruang Seminar TULT',
            'gedung' => 'Gedung TULT',
            'kapasitas' => 150,
            'fasilitas' => 'AC, Proyektor, Audio System',
            'provinsi_id' => '32',
            'kota_id' => '3204',
            'kecamatan_id' => '3204050'
        ]);
    }
}
