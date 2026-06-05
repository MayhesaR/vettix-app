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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Check if database already has users to prevent data loss on container restarts
        if (User::exists()) {
            $this->command->info('⚠️ Database already contains data. Skipping seeding.');
            return;
        }

        // Clean database tables in safe reverse dependency order
        $this->command->info('🧹 Cleaning existing database records...');
        Ranking::query()->delete();
        Review::query()->delete();
        Certificate::query()->delete();
        Participant::query()->delete();
        Speaker::query()->delete();
        Event::query()->delete();
        Venue::query()->delete();
        Category::query()->delete();
        User::query()->delete();
        $this->command->info('✨ Database cleaned.');

        // Run modular seeders in order
        $this->command->info('🌱 Seeding database...');
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            VenueSeeder::class,
            EventSeeder::class,
            SpeakerSeeder::class,
            ParticipantSeeder::class,
            CertificateSeeder::class,
            ReviewSeeder::class,
            RankingSeeder::class,
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
