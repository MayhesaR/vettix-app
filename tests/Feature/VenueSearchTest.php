<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VenueSearchTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $venue1;
    protected $venue2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->venue1 = Venue::create([
            'nama_venue' => 'Auditorium Gd. K',
            'gedung' => 'Gedung K',
            'provinsi_id' => '1',
            'kota_id' => '1',
            'kecamatan_id' => '1',
            'kapasitas' => 500,
            'fasilitas' => 'AC, Sound System, WiFi'
        ]);

        $this->venue2 = Venue::create([
            'nama_venue' => 'Lab Komputer 3',
            'gedung' => 'Gedung Damar',
            'provinsi_id' => '1',
            'kota_id' => '1',
            'kecamatan_id' => '1',
            'kapasitas' => 50,
            'fasilitas' => 'WiFi, Projector'
        ]);
    }

    public function test_venue_index_shows_all_venues_when_no_search(): void
    {
        $response = $this->actingAs($this->admin)->get('/venues');

        $response->assertStatus(200);
        $response->assertSee('Auditorium Gd. K');
        $response->assertSee('Lab Komputer 3');
    }

    public function test_venue_index_filters_by_name(): void
    {
        $response = $this->actingAs($this->admin)->get('/venues?search=Auditorium');

        $response->assertStatus(200);
        $response->assertSee('Auditorium Gd. K');
        $response->assertDontSee('Lab Komputer 3');
    }

    public function test_venue_index_filters_by_building(): void
    {
        $response = $this->actingAs($this->admin)->get('/venues?search=Damar');

        $response->assertStatus(200);
        $response->assertDontSee('Auditorium Gd. K');
        $response->assertSee('Lab Komputer 3');
    }

    public function test_venue_index_filters_by_facilities(): void
    {
        $response = $this->actingAs($this->admin)->get('/venues?search=Projector');

        $response->assertStatus(200);
        $response->assertDontSee('Auditorium Gd. K');
        $response->assertSee('Lab Komputer 3');
    }

    public function test_venue_pdf_export_filters_by_search(): void
    {
        $response = $this->actingAs($this->admin)->get('/venues/export/pdf?search=Projector');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
