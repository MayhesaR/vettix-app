<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Certificate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;
    protected $venue;
    protected $event;
    protected $participant;

    protected function setUp(): void
    {
        parent::setUp();

        // Create user, venue, category, event, and participant for test data
        $this->user = User::factory()->create();

        $this->category = Category::create([
            'nama_kategori' => 'Seminar'
        ]);

        $this->venue = Venue::create([
            'nama_venue' => 'Auditorium Gd. K',
            'gedung' => 'Gedung Damar',
            'kapasitas' => 500,
            'provinsi_id' => '1',
            'kota_id' => '1',
            'kecamatan_id' => '1',
        ]);

        $this->event = Event::create([
            'nama_event' => 'Laravel 12 Launch Event',
            'tanggal_event' => '2026-06-01',
            'deskripsi' => 'An event discussing Laravel 12 features.',
            'venue_id' => $this->venue->id,
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $this->participant = Participant::create([
            'nama_peserta' => 'John Doe',
            'nim' => '1234567890',
            'email' => 'john.doe@example.com',
            'asal_instansi' => 'Institut Teknologi',
            'status_kehadiran' => 'hadir',
            'event_id' => $this->event->id,
        ]);
    }

    public function test_guest_cannot_access_certificates(): void
    {
        $response = $this->get('/certificates');
        $response->assertRedirect('/login');
    }

    public function test_certificates_index_screen_can_be_rendered(): void
    {
        $response = $this->actingAs($this->user)->get('/certificates');
        $response->assertStatus(200);
    }

    public function test_certificate_creation_generates_pdf_and_saves_it_to_storage(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->user)->post('/certificates', [
            'participant_id' => $this->participant->id,
            'event_id' => $this->event->id,
        ]);

        $response->assertRedirect('/certificates');

        // Retrieve created certificate
        $certificate = Certificate::first();
        $this->assertNotNull($certificate);
        $this->assertEquals($this->participant->id, $certificate->participant_id);
        $this->assertEquals($this->event->id, $certificate->event_id);

        // Assert file exists in fake storage
        $filename = str_replace('/', '-', $certificate->no_sertifikat) . '.pdf';
        Storage::disk('public')->assertExists('certificates/' . $filename);
        $this->assertEquals('/storage/certificates/' . $filename, $certificate->file_path);
    }

    public function test_certificate_deletion_removes_pdf_from_storage(): void
    {
        Storage::fake('public');

        // Create the certificate manually via HTTP post to invoke generation
        $this->actingAs($this->user)->post('/certificates', [
            'participant_id' => $this->participant->id,
            'event_id' => $this->event->id,
        ]);

        $certificate = Certificate::first();
        $filename = str_replace('/', '-', $certificate->no_sertifikat) . '.pdf';
        Storage::disk('public')->assertExists('certificates/' . $filename);

        // Delete the certificate
        $response = $this->actingAs($this->user)->delete('/certificates/' . $certificate->id);
        $response->assertStatus(302); // Redirect back

        // Assert database and file are gone
        $this->assertDatabaseMissing('certificates', ['id' => $certificate->id]);
        Storage::disk('public')->assertMissing('certificates/' . $filename);
    }
}
