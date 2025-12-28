<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
