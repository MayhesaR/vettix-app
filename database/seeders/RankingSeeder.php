<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ranking;
use App\Models\Participant;
use App\Models\Event;

class RankingSeeder extends Seeder
{
    public function run(): void
    {
        $event3 = Event::find(3);
        $event3Id = $event3 ? $event3->id : 3;

        $fajar = Participant::where('nama_peserta', 'Fajar Nugraha')->first();
        $indah = Participant::where('nama_peserta', 'Indah Sari')->first();
        $putri = Participant::where('nama_peserta', 'Putri Anggraini')->first();
        $andi = Participant::where('nama_peserta', 'Andi Saputra')->first();

        if ($fajar) {
            Ranking::create([
                'participant_id' => $fajar->id,
                'event_id' => $event3Id,
                'rank' => 1,
                'score' => 98.5,
                'achievement' => 'Juara 1',
                'notes' => 'Solusi inovatif Smart Parking System dengan IoT integration',
            ]);
        }

        if ($indah) {
            Ranking::create([
                'participant_id' => $indah->id,
                'event_id' => $event3Id,
                'rank' => 2,
                'score' => 95.0,
                'achievement' => 'Juara 2',
                'notes' => 'Smart Waste Management dengan AI detection',
            ]);
        }

        if ($putri) {
            Ranking::create([
                'participant_id' => $putri->id,
                'event_id' => $event3Id,
                'rank' => 3,
                'score' => 92.5,
                'achievement' => 'Juara 3',
                'notes' => 'Traffic Monitoring System using Computer Vision',
            ]);
        }

        if ($andi) {
            Ranking::create([
                'participant_id' => $andi->id,
                'event_id' => $event3Id,
                'rank' => 4,
                'score' => 88.0,
                'achievement' => 'Honorable Mention',
                'notes' => 'Smart Street Lighting dengan sensor cahaya otomatis',
            ]);
        }
    }
}
