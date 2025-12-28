<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Event;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('event');

        if ($request->has('event_id') && $request->event_id != '') {
            $query->where('event_id', $request->event_id);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(10);

        $avgRating = $query->avg('rating') ?? 0;

        $events = Event::all();

        return view('reviews.index', compact('reviews', 'avgRating', 'events'));
    }

    public function create()
    {
        $events = Event::all();
        return view('reviews.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'participant_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        $name = urlencode($request->participant_name);
        $avatarUrl = "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&rounded=true";

        Review::create([
            'event_id' => $request->event_id,
            'participant_name' => $request->participant_name,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'avatar_visual_url' => $avatarUrl,
            'is_published' => true,
            'user_id' => auth()->id() ?? null,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $events = Event::all();
        return view('reviews.edit', compact('review', 'events'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'participant_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        $review = Review::findOrFail($id);
        
        $name = urlencode($request->participant_name);
        $avatarUrl = "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&rounded=true";

        $review->update([
            'event_id' => $request->event_id,
            'participant_name' => $request->participant_name,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'avatar_visual_url' => $avatarUrl,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review berhasil diupdate!');
    }

    public function toggleStatus($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_published' => !$review->is_published]);

        return redirect()->back()->with('success', 'Status review berhasil diubah!');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Review berhasil dihapus!');
    }
}

