<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venues';

    protected $fillable = [
        'nama_venue',
        'gedung',
        'kapasitas',
        'fasilitas',
        'provinsi_id',
        'kota_id',
        'kecamatan_id'
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'venue_id');
    }
}
