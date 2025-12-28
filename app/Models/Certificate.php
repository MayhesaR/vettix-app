<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_sertifikat',
        'file_path',
        'qr_code_url',
        'participant_id',
        'event_id'
    ];

    public function participant() {
        return $this->belongsTo(Participant::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
