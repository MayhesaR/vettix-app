<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'participant_name',
        'komentar',
        'rating',
        'avatar_visual_url',
        'is_published',
        'user_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_visual_url) {
            return $this->avatar_visual_url;
        }

        $name = urlencode($this->participant_name ?? 'User');
        return "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&rounded=true";
    }
}
