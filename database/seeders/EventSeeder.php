<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use App\Models\Venue;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;

        $seminarCat = Category::where('nama_kategori', 'Seminar Nasional')->first();
        $workshopCat = Category::where('nama_kategori', 'Workshop / Pelatihan')->first();
        $lombaCat = Category::where('nama_kategori', 'Lomba / Kompetisi')->first();
        $konfCat = Category::where('nama_kategori', 'Konferensi')->first();

        $auditorium = Venue::where('nama_venue', 'Auditorium Gd. K')->first();
        $lab = Venue::where('nama_venue', 'Lab Komputer Dasar')->first();
        $tult = Venue::where('nama_venue', 'Ruang Seminar TULT')->first();

        Event::create([
            'nama_event' => 'Seminar Teknologi AI & Machine Learning',
            'deskripsi' => 'Seminar nasional membahas perkembangan terkini AI dan Machine Learning dalam industri',
            'tanggal_event' => Carbon::now()->subDays(15)->format('Y-m-d'),
            'category_id' => $seminarCat ? $seminarCat->id : 1,
            'venue_id' => $auditorium ? $auditorium->id : 1,
            'user_id' => $adminId,
        ]);

        Event::create([
            'nama_event' => 'Workshop Web Development dengan Laravel',
            'deskripsi' => 'Pelatihan intensif pembuatan aplikasi web menggunakan framework Laravel',
            'tanggal_event' => Carbon::now()->subDays(7)->format('Y-m-d'),
            'category_id' => $workshopCat ? $workshopCat->id : 2,
            'venue_id' => $lab ? $lab->id : 2,
            'user_id' => $adminId,
        ]);

        Event::create([
            'nama_event' => 'Kompetisi Hackathon 2025',
            'deskripsi' => 'Lomba pemrograman tingkat nasional dengan tema Smart City Solutions',
            'tanggal_event' => Carbon::now()->subDays(3)->format('Y-m-d'),
            'category_id' => $lombaCat ? $lombaCat->id : 3,
            'venue_id' => $tult ? $tult->id : 3,
            'user_id' => $adminId,
        ]);

        Event::create([
            'nama_event' => 'Konferensi Cyber Security Indonesia',
            'deskripsi' => 'Konferensi internasional membahas keamanan siber dan data protection',
            'tanggal_event' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'category_id' => $konfCat ? $konfCat->id : 4,
            'venue_id' => $auditorium ? $auditorium->id : 1,
            'user_id' => $adminId,
        ]);
    }
}
