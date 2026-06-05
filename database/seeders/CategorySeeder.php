<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Seminar Nasional', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Workshop / Pelatihan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Lomba / Kompetisi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Konferensi', 'created_at' => now(), 'updated_at' => now()],
        ];

        Category::insert($categories);
    }
}
