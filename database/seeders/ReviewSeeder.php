<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Event;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $event1 = Event::find(1);
        $event2 = Event::find(2);
        $event3 = Event::find(3);

        $event1Id = $event1 ? $event1->id : 1;
        $event2Id = $event2 ? $event2->id : 2;
        $event3Id = $event3 ? $event3->id : 3;

        Review::create([
            'participant_name' => 'Budi Santoso',
            'rating' => 5,
            'komentar' => 'Seminar sangat menarik! Narasumber sangat menguasai materi AI. Saya jadi lebih paham tentang Machine Learning. Terima kasih!',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event1Id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Siti Aminah',
            'rating' => 4,
            'komentar' => 'Materi bagus, tapi AC terlalu dingin. Mohon diatur suhu ruangannya untuk event berikutnya.',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Siti+Aminah&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event1Id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Doni Prakoso',
            'rating' => 5,
            'komentar' => 'Workshop Laravel sangat aplikatif! Instruktur menjelaskan step-by-step dengan jelas. Recommended!',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Doni+Prakoso&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event2Id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Lisa Permata',
            'rating' => 5,
            'komentar' => 'Sangat puas dengan workshop ini. Materinya up-to-date dan langsung bisa dipraktekkan. Thank you!',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Lisa+Permata&background=random&color=fff&rounded=true',
            'is_published' => true,
            'event_id' => $event2Id,
            'user_id' => null,
        ]);

        Review::create([
            'participant_name' => 'Indah Sari',
            'rating' => 3,
            'komentar' => 'Hackathon seru, tapi waktunya terlalu singkat. Mungkin bisa diperpanjang untuk event selanjutnya.',
            'avatar_visual_url' => 'https://ui-avatars.com/api/?name=Indah+Sari&background=random&color=fff&rounded=true',
            'is_published' => false,
            'event_id' => $event3Id,
            'user_id' => null,
        ]);
    }
}
