<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    protected $fillable = [
        'username_platform',
        'nama_lengkap',
        'role_job',
        'instansi',
        'bio_singkat',
        'avatar_url',
        'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
