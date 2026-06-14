<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\Participant;
use App\Models\Certificate;
use App\Models\Review;
use App\Models\Ranking;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PerformanceTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting Performance Test Seeder...');

        // 1. Create Users
        $this->command->info('👤 Creating Users...');
        $admin = User::create([
            'name' => 'Performance Admin',
            'email' => 'perf.admin@vettix.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = User::create([
                'name' => "User Tester $i",
                'email' => "user.tester$i@vettix.com",
                'password' => Hash::make('password123'),
                'role' => 'peserta',
            ]);
        }

        // 2. Create Categories
        $this->command->info('🏷️ Creating Categories...');
        $categoryNames = [
            'Seminar Nasional', 'Workshop / Pelatihan', 'Lomba / Kompetisi', 
            'Konferensi', 'Bootcamp Intensif', 'Talkshow Interaktif', 
            'Webinar Global', 'Sertifikasi Profesi'
        ];
        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[] = Category::create(['nama_kategori' => $name]);
        }

        // 3. Create Venues
        $this->command->info('🏢 Creating Venues...');
        $venueTemplates = [
            ['nama' => 'Auditorium Gd. K', 'gedung' => 'Gedung K'],
            ['nama' => 'Lab Komputer Dasar', 'gedung' => 'Gedung FIK'],
            ['nama' => 'Ruang Seminar TULT', 'gedung' => 'Gedung TULT'],
            ['nama' => 'Aula Nusantara', 'gedung' => 'Gedung Rektorat'],
            ['nama' => 'Teater Multimedia', 'gedung' => 'Gedung Tokong Nanas'],
            ['nama' => 'Lab Jaringan Komputer', 'gedung' => 'Gedung FIK'],
            ['nama' => 'Ruang Kelas 401', 'gedung' => 'Gedung Kuliah Bersama'],
            ['nama' => 'Ruang Kelas 402', 'gedung' => 'Gedung Kuliah Bersama'],
            ['nama' => 'Co-Working Space', 'gedung' => 'Gedung Telkom Bandung'],
            ['nama' => 'Convention Hall', 'gedung' => 'Gedung Serbaguna'],
        ];
        $venues = [];
        foreach ($venueTemplates as $vt) {
            $venues[] = Venue::create([
                'nama_venue' => $vt['nama'],
                'gedung' => $vt['gedung'],
                'kapasitas' => rand(50, 500),
                'fasilitas' => 'AC, Proyektor, Sound System, High Speed Wi-Fi, Kursi Ergonomis',
                'provinsi_id' => '32',
                'kota_id' => '3273',
                'kecamatan_id' => '327325',
            ]);
        }

        // 4. Create Events
        $this->command->info('📅 Creating Events...');
        $eventPrefixes = ['Seminar Nasional', 'Workshop', 'Simposium', 'Diskusi Panel', 'Pelatihan', 'Kuliah Umum'];
        $eventTopics = ['React & Next.js', 'Cyber Security Essentials', 'DevOps & CI/CD', 'Blockchain Technology', 'Data Science dengan Python', 'UI/UX Design Masterclass', 'Internet of Things (IoT)', 'Sistem Informasi Kampus'];
        
        $events = [];
        for ($i = 1; $i <= 100; $i++) {
            $title = $eventPrefixes[rand(0, count($eventPrefixes)-1)] . ' ' . $eventTopics[rand(0, count($eventTopics)-1)] . ' Part ' . $i;
            $cat = $categories[rand(0, count($categories)-1)];
            $ven = $venues[rand(0, count($venues)-1)];
            $date = Carbon::now()->addDays(rand(-60, 60));

            $events[] = Event::create([
                'nama_event' => $title,
                'deskripsi' => "Ini adalah deskripsi detail untuk event $title yang diselenggarakan untuk tujuan pengujian performa sistem Vettix.",
                'tanggal_event' => $date->format('Y-m-d'),
                'category_id' => $cat->id,
                'venue_id' => $ven->id,
                'user_id' => $admin->id,
            ]);
        }

        // 5. Create Speakers
        $this->command->info('🎙️ Creating Speakers...');
        $speakerNames = [
            'Rizky Pratama', 'Aditya Wijaya', 'Bambang Subianto', 'Siti Rahmawati', 
            'Dewi Lestari', 'Fajar Ramadhan', 'Indra Hermawan', 'Larasati Putri',
            'Mega Utami', 'Nugroho Susanto', 'Putu Wijaya', 'Rian Hidayat', 
            'Siska Amelia', 'Taufik Hidayat', 'Yuni Kartika', 'Zulfikar Ali'
        ];
        
        foreach ($speakerNames as $name) {
            $evt = $events[rand(0, count($events)-1)];
            Speaker::create([
                'username_platform' => strtolower(str_replace(' ', '', $name)),
                'nama_lengkap' => $name,
                'role_job' => ['Software Engineer', 'Data Scientist', 'SecOps Specialist', 'Product Manager'][rand(0, 3)],
                'instansi' => ['Google', 'Gojek', 'Tokopedia', 'Microsoft', 'Telkom Indonesia'][rand(0, 4)],
                'bio_singkat' => "Pembicara berpengalaman di bidang teknologi informasi selama lebih dari " . rand(5, 15) . " tahun.",
                'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random',
                'event_id' => $evt->id,
            ]);
        }

        // 6. Create Participants
        $this->command->info('👥 Creating Participants...');
        $firstNames = ['Budi', 'Siti', 'Ahmad', 'Rina', 'Doni', 'Lisa', 'Rama', 'Indah', 'Fajar', 'Putri', 'Andi', 'Eka', 'Hadi', 'Gita', 'Joko', 'Kartika', 'Muhamad', 'Novi', 'Oki', 'Rian', 'Sari', 'Tomi', 'Wulan', 'Yudi'];
        $lastNames = ['Santoso', 'Aminah', 'Fadli', 'Wati', 'Prakoso', 'Permata', 'Wijaya', 'Sari', 'Nugraha', 'Anggraini', 'Saputra', 'Lestari', 'Kusuma', 'Fitriani', 'Susilo', 'Dewi', 'Hidayat', 'Putra', 'Pratama', 'Utami', 'Wahyuni'];

        $participants = [];
        $nimCounter = 1301210000;
        
        for ($i = 1; $i <= 1000; $i++) {
            $name = $firstNames[rand(0, count($firstNames)-1)] . ' ' . $lastNames[rand(0, count($lastNames)-1)];
            $nim = (string)($nimCounter + $i);
            $email = strtolower(str_replace(' ', '', $name)) . $i . '@student.telkomuniversity.ac.id';
            $evt = $events[rand(0, count($events)-1)];
            
            $participants[] = Participant::create([
                'nama_peserta' => $name,
                'nim' => $nim,
                'email' => $email,
                'asal_instansi' => 'Telkom University',
                'status_kehadiran' => ['hadir', 'tidak_hadir'][rand(0, 1)],
                'event_id' => $evt->id,
            ]);
        }

        // 7. Create Certificates
        $this->command->info('📜 Creating Certificates...');
        $certCount = 0;
        foreach ($participants as $p) {
            if ($p->status_kehadiran === 'hadir' && $certCount < 500) {
                $no_sertifikat = 'SR-' . str_pad($certCount + 1, 4, '0', STR_PAD_LEFT) . '/' . date('Y');
                Certificate::create([
                    'no_sertifikat' => $no_sertifikat,
                    'file_path' => '/storage/certificates/' . str_replace('/', '-', $no_sertifikat) . '.pdf',
                    'qr_code_url' => "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($no_sertifikat),
                    'participant_id' => $p->id,
                    'event_id' => $p->event_id,
                ]);
                $certCount++;
            }
        }

        // 8. Create Reviews
        $this->command->info('⭐ Creating Reviews...');
        $reviewTexts = [
            'Event yang sangat menarik dan menambah wawasan!',
            'Materi yang disampaikan sangat relevan dengan kebutuhan industri saat ini.',
            'Pembicara sangat komunikatif dan penjelasannya mudah dipahami.',
            'Fasilitas ruangan sangat baik, namun pendingin udara agak terlalu dingin.',
            'Sangat bermanfaat. Semoga ke depan diadakan lagi event serupa.',
            'Penyelenggaraan secara keseluruhan cukup baik dan teratur.',
            'Waktunya kurang lama untuk sesi tanya jawab.',
            'Materi slide presentasi sangat bagus.'
        ];

        for ($i = 1; $i <= 400; $i++) {
            $p = $participants[rand(0, count($participants)-1)];
            Review::create([
                'participant_name' => $p->nama_peserta,
                'rating' => rand(3, 5),
                'komentar' => $reviewTexts[rand(0, count($reviewTexts)-1)],
                'avatar_visual_url' => 'https://ui-avatars.com/api/?name=' . urlencode($p->nama_peserta) . '&background=random&color=fff&rounded=true',
                'is_published' => [true, false][rand(0, 1)],
                'event_id' => $p->event_id,
                'user_id' => null,
            ]);
        }

        // 9. Create Rankings
        $this->command->info('🏆 Creating Rankings...');
        $lombaEvents = Event::where('category_id', $categories[2]->id)->get();
        
        foreach ($lombaEvents as $le) {
            $eps = Participant::where('event_id', $le->id)->get();
            if ($eps->count() >= 3) {
                Ranking::create([
                    'participant_id' => $eps[0]->id,
                    'event_id' => $le->id,
                    'rank' => 1,
                    'score' => 95.0,
                    'achievement' => 'Juara 1',
                    'notes' => 'Pemenang Utama dengan proyek terbaik',
                ]);
                Ranking::create([
                    'participant_id' => $eps[1]->id,
                    'event_id' => $le->id,
                    'rank' => 2,
                    'score' => 90.0,
                    'achievement' => 'Juara 2',
                    'notes' => 'Pemenang kedua dengan presentasi solid',
                ]);
                Ranking::create([
                    'participant_id' => $eps[2]->id,
                    'event_id' => $le->id,
                    'rank' => 3,
                    'score' => 85.0,
                    'achievement' => 'Juara 3',
                    'notes' => 'Pemenang ketiga dengan implementasi baik',
                ]);
            }
        }

        $this->command->info('✅ Performance Test Seeder completed successfully!');
    }
}
