<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@telkomuniversity.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Peserta 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@student.telkomuniversity.ac.id',
            'password' => bcrypt('password'),
            'role' => 'peserta'
        ]);

        // Peserta 2
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@student.telkomuniversity.ac.id',
            'password' => bcrypt('password'),
            'role' => 'peserta'
        ]);

        // Peserta 3
        User::create([
            'name' => 'Ahmad Fadli',
            'email' => 'ahmad@student.telkomuniversity.ac.id',
            'password' => bcrypt('password'),
            'role' => 'peserta'
        ]);
    }
}
