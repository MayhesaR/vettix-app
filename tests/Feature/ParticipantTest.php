<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Category;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;
    protected $venue;
    protected $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'peserta'
        ]);

        $this->category = Category::create([
            'nama_kategori' => 'Workshop'
        ]);

        $this->venue = Venue::create([
            'nama_venue' => 'Lab Komputer 3',
            'gedung' => 'Gedung Damar',
            'kapasitas' => 50,
            'provinsi_id' => '1',
            'kota_id' => '1',
            'kecamatan_id' => '1',
        ]);

        $this->event = Event::create([
            'nama_event' => 'Docker for Beginners',
            'tanggal_event' => '2026-06-15',
            'deskripsi' => 'Learn Docker concepts and commands.',
            'venue_id' => $this->venue->id,
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_guest_cannot_access_self_registration_form(): void
    {
        $response = $this->get('/register-event/' . $this->event->id);
        $response->assertRedirect('/login');
    }

    public function test_participant_can_view_self_registration_form(): void
    {
        $response = $this->actingAs($this->user)->get('/register-event/' . $this->event->id);
        $response->assertStatus(200);
        $response->assertSee('Daftar Event Baru');
        $response->assertSee($this->event->nama_event);
    }

    public function test_participant_can_self_register_successfully(): void
    {
        $response = $this->actingAs($this->user)->post('/register-event/' . $this->event->id, [
            'nim' => '1301210099',
            'asal_instansi' => 'Telkom University',
        ]);

        $response->assertRedirect('/dashboard');
        
        $this->assertDatabaseHas('participants', [
            'nama_peserta' => $this->user->name,
            'nim' => '1301210099',
            'email' => $this->user->email,
            'asal_instansi' => 'Telkom University',
            'status_kehadiran' => 'tidak_hadir',
            'event_id' => $this->event->id,
        ]);
    }

    public function test_participant_cannot_self_register_twice_for_same_event(): void
    {
        // First registration
        Participant::create([
            'nama_peserta' => $this->user->name,
            'nim' => '1301210099',
            'email' => $this->user->email,
            'asal_instansi' => 'Telkom University',
            'status_kehadiran' => 'tidak_hadir',
            'event_id' => $this->event->id,
        ]);

        // Second registration attempt
        $response = $this->actingAs($this->user)->post('/register-event/' . $this->event->id, [
            'nim' => '1301210099',
            'asal_instansi' => 'Telkom University',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'Anda sudah terdaftar di event ini!');
    }
}
