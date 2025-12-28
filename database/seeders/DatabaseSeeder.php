<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Venue;
use App\Models\User;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Speaker;
use App\Models\Certificate;
use App\Models\Review;
use App\Models\Ranking;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Admin
        $admin = User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@telkomuniversity.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // 2. Isi Data Kategori
        $categories = Category::insert([
            ['nama_kategori' => 'Seminar Nasional', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Workshop / Pelatihan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Lomba / Kompetisi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Konferensi', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Isi Data Venue
        $venue1 = Venue::create([
            'nama_venue' => 'Auditorium Gd. K',
            'gedung' => 'Gedung K',
            'kapasitas' => 500,
            'fasilitas' => 'AC, Sound System, Proyektor Besar',
            'provinsi_id' => '32',
            'kota_id' => '3204',
            'kecamatan_id' => '3204050'
        ]);

        $venue2 = Venue::create([
            'nama_venue' => 'Lab Komputer Dasar',
            'gedung' => 'Gedung Tokong Nanas',
            'kapasitas' => 40,
            'fasilitas' => '40 PC, AC, Whiteboard',
            'provinsi_id' => '32',
            'kota_id' => '3204',
            'kecamatan_id' => '3204050'
        ]);

        $venue3 = Venue::create([
            'nama_venue' => 'Ruang Seminar TULT',
            'gedung' => 'Gedung TULT',
            'kapasitas' => 150,
            'fasilitas' => 'AC, Proyektor, Audio System',
            'provinsi_id' => '32',
            'kota_id' => '3204',
            'kecamatan_id' => '3204050'
        ]);

        // 4. Isi Data Event
        $event1 = Event::create([
            'nama_event' => 'Seminar Teknologi AI & Machine Learning',
            'deskripsi' => 'Seminar nasional membahas perkembangan terkini AI dan Machine Learning dalam industri',
            'tanggal_event' => Carbon::now()->subDays(15),
            'category_id' => 1,
            'venue_id' => $venue1->id,
            'user_id' => $admin->id,
        ]);

        $event2 = Event::create([
            'nama_event' => 'Workshop Web Development dengan Laravel',
            'deskripsi' => 'Pelatihan intensif pembuatan aplikasi web menggunakan framework Laravel',
            'tanggal_event' => Carbon::now()->subDays(7),
            'category_id' => 2,
            'venue_id' => $venue2->id,
            'user_id' => $admin->id,
        ]);

        $event3 = Event::create([
            'nama_event' => 'Kompetisi Hackathon 2025',
            'deskripsi' => 'Lomba pemrograman tingkat nasional dengan tema Smart City Solutions',
            'tanggal_event' => Carbon::now()->subDays(3),
            'category_id' => 3,
            'venue_id' => $venue3->id,
            'user_id' => $admin->id,
        ]);

        $event4 = Event::create([
            'nama_event' => 'Konferensi Cyber Security Indonesia',
            'deskripsi' => 'Konferensi internasional membahas keamanan siber dan data protection',
            'tanggal_event' => Carbon::now()->addDays(10),
            'category_id' => 4,
            'venue_id' => $venue1->id,
            'user_id' => $admin->id,
        ]);

        // 5. Isi Data Speakers
        Speaker::create([
            'username_platform' => 'ryzalyusoff',
            'nama_lengkap' => 'Dr. Rizal Yusoff',
            'role_job' => 'AI Research Scientist',
            'instansi' => 'Google Indonesia',
            'bio_singkat' => 'Expert in Machine Learning and Deep Learning with 10+ years experience',
            'avatar_url' => 'https://ui-avatars.com/api/?name=Rizal+Yusoff&background=random',
            'event_id' => $event1->id,
        ]);

        Speaker::create([
            'username_platform' => 'sandhikagalih',
            'nama_lengkap' => 'Sandhika Galih',
            'role_job' => 'Full Stack Developer',
            'instansi' => 'Web Programming UNPAS',
            'bio_singkat' => 'Passionate web developer and educator, Laravel enthusiast',
            'avatar_url' => 'https://ui-avatars.com/api/?name=Sandhika+Galih&background=random',
            'event_id' => $event2->id,
        ]);

        Speaker::create([
            'username_platform' => 'ditdittdittt',
            'nama_lengkap' => 'Aditya Rahman',
            'role_job' => 'Cybersecurity Specialist',
            'instansi' => 'Bank Indonesia',
            'bio_singkat' => 'Certified Ethical Hacker and Security Consultant',
            'avatar_url' => 'https://ui-avatars.com/api/?name=Aditya+Rahman&background=random',
            'event_id' => $event4->id,
        ]);

        // 6. Isi Data Participants
        $participants = [
            ['nama_peserta' => 'Budi Santoso', 'nim' => '1301210001', 'email' => 'budi@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event1->id],
            ['nama_peserta' => 'Siti Aminah', 'nim' => '1301210002', 'email' => 'siti@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event1->id],
            ['nama_peserta' => 'Ahmad Fadli', 'nim' => '1301210003', 'email' => 'ahmad@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event1->id],
            ['nama_peserta' => 'Rina Wati', 'nim' => '1301210004', 'email' => 'rina@student.itb.ac.id', 'asal_instansi' => 'ITB Bandung', 'status_kehadiran' => 'tidak_hadir', 'event_id' => $event1->id],

            ['nama_peserta' => 'Doni Prakoso', 'nim' => '1301210005', 'email' => 'doni@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event2->id],
            ['nama_peserta' => 'Lisa Permata', 'nim' => '1301210006', 'email' => 'lisa@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event2->id],
            ['nama_peserta' => 'Rama Wijaya', 'nim' => '1301210007', 'email' => 'rama@student.unpad.ac.id', 'asal_instansi' => 'Universitas Padjadjaran', 'status_kehadiran' => 'hadir', 'event_id' => $event2->id],

            ['nama_peserta' => 'Indah Sari', 'nim' => '1301210008', 'email' => 'indah@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event3->id],
            ['nama_peserta' => 'Fajar Nugraha', 'nim' => '1301210009', 'email' => 'fajar@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event3->id],
            ['nama_peserta' => 'Putri Anggraini', 'nim' => '1301210010', 'email' => 'putri@student.ui.ac.id', 'asal_instansi' => 'Universitas Indonesia', 'status_kehadiran' => 'hadir', 'event_id' => $event3->id],
            ['nama_peserta' => 'Andi Saputra', 'nim' => '1301210011', 'email' => 'andi@student.ugm.ac.id', 'asal_instansi' => 'Universitas Gadjah Mada', 'status_kehadiran' => 'hadir', 'event_id' => $event3->id],
        ];

        foreach ($participants as $p) {
            Participant::create($p);
        }

        // 7. Isi Data Certificates (untuk peserta yang hadir)
        $hadirParticipants = Participant::where('status_kehadiran', 'hadir')->get();
        foreach ($hadirParticipants as $index => $participant) {
            $no_sertifikat = 'SR-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '/2025';
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($no_sertifikat);

            Certificate::create([
                'no_sertifikat' => $no_sertifikat,
                'file_path' => '/storage/certificates/' . $no_sertifikat . '.pdf',
                'qr_code_url' => $qrUrl,
                'participant_id' => $participant->id,
                'event_id' => $participant->event_id,
            ]);
        }

        // 8. Isi Data Reviews
        Review::create([
            'participant_name' => 'Budi Santoso',
            'rating' => 5,
            'komentar' => 'Seminar sangat menarik! Narasumber sangat menguasai materi AI. Saya jadi lebih paham tentang Machine Learning. Terima kasih!',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event1->id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Siti Aminah',
            'rating' => 4,
            'komentar' => 'Materi bagus, tapi AC terlalu dingin. Mohon diatur suhu ruangannya untuk event berikutnya.',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Siti+Aminah&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event1->id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Doni Prakoso',
            'rating' => 5,
            'komentar' => 'Workshop Laravel sangat aplikatif! Instruktur menjelaskan step-by-step dengan jelas. Recommended!',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Doni+Prakoso&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event2->id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Lisa Permata',
            'rating' => 5,
            'komentar' => 'Sangat puas dengan workshop ini. Materinya up-to-date dan langsung bisa dipraktekkan. Thank you!',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Lisa+Permata&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event2->id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Indah Sari',
            'rating' => 3,
            'komentar' => 'Hackathon seru, tapi waktunya terlalu singkat. Mungkin bisa diperpanjang untuk event selanjutnya.',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Indah+Sari&background=random&color=fff&rounded=true',
            'is_published' => false,
            'event_id' => $event3->id,
            'user_id' => null,
        ]);

        // 9. Isi Data Rankings (untuk event kompetisi)
        Ranking::create([
            'participant_id' => Participant::where('nama_peserta', 'Fajar Nugraha')->first()->id,
            'event_id' => $event3->id,
            'rank' => 1,
            'score' => 98.5,
            'achievement' => 'Juara 1',
            'notes' => 'Solusi inovatif Smart Parking System dengan IoT integration',
        ]);

        Ranking::create([
            'participant_id' => Participant::where('nama_peserta', 'Indah Sari')->first()->id,
            'event_id' => $event3->id,
            'rank' => 2,
            'score' => 95.0,
            'achievement' => 'Juara 2',
            'notes' => 'Smart Waste Management dengan AI detection',
        ]);

        Ranking::create([
            'participant_id' => Participant::where('nama_peserta', 'Putri Anggraini')->first()->id,
            'event_id' => $event3->id,
            'rank' => 3,
            'score' => 92.5,
            'achievement' => 'Juara 3',
            'notes' => 'Traffic Monitoring System using Computer Vision',
        ]);

        Ranking::create([
            'participant_id' => Participant::where('nama_peserta', 'Andi Saputra')->first()->id,
            'event_id' => $event3->id,
            'rank' => 4,
            'score' => 88.0,
            'achievement' => 'Honorable Mention',
            'notes' => 'Smart Street Lighting dengan sensor cahaya otomatis',
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📊 Total data created:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Categories: ' . Category::count());
        $this->command->info('   - Venues: ' . Venue::count());
        $this->command->info('   - Events: ' . Event::count());
        $this->command->info('   - Speakers: ' . Speaker::count());
        $this->command->info('   - Participants: ' . Participant::count());
        $this->command->info('   - Certificates: ' . Certificate::count());
        $this->command->info('   - Reviews: ' . Review::count());
        $this->command->info('   - Rankings: ' . Ranking::count());
    }
}
