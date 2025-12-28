<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peserta',
        'nim',
        'email',
        'asal_instansi',
        'status_kehadiran',
        'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
