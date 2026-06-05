<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Speaker;
use App\Models\Event;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $event1 = Event::find(1);
        $event2 = Event::find(2);
        $event4 = Event::find(4);

        if ($event1) {
            Speaker::create([
                'username_platform' => 'ryzalyusoff',
                'nama_lengkap' => 'Dr. Rizal Yusoff',
                'role_job' => 'AI Research Scientist',
                'instansi' => 'Google Indonesia',
                'bio_singkat' => 'Expert in Machine Learning and Deep Learning with 10+ years experience',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Rizal+Yusoff&background=random',
                'event_id' => $event1->id,
            ]);
        }

        if ($event2) {
            Speaker::create([
                'username_platform' => 'sandhikagalih',
                'nama_lengkap' => 'Sandhika Galih',
                'role_job' => 'Full Stack Developer',
                'instansi' => 'Web Programming UNPAS',
                'bio_singkat' => 'Passionate web developer and educator, Laravel enthusiast',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Sandhika+Galih&background=random',
                'event_id' => $event2->id,
            ]);
        }

        if ($event4) {
            Speaker::create([
                'username_platform' => 'ditdittdittt',
                'nama_lengkap' => 'Aditya Rahman',
                'role_job' => 'Cybersecurity Specialist',
                'instansi' => 'Bank Indonesia',
                'bio_singkat' => 'Certified Ethical Hacker and Security Consultant',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Aditya+Rahman&background=random',
                'event_id' => $event4->id,
            ]);
        }
    }
}
