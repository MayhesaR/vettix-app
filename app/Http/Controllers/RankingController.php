<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\Participant;
use App\Models\Event;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::withCount('rankings')->orderBy('tanggal_event', 'desc')->get();

        $selectedEventId = $request->get('event_id');

        if ($selectedEventId) {
            $selectedEvent = Event::with(['rankings' => function($query) {
                $query->with('participant')->orderBy('rank', 'asc')->orderBy('score', 'desc');
            }])->findOrFail($selectedEventId);

            $rankings = $selectedEvent->rankings;
            $groupedRankings = collect([$selectedEvent]);
        } else {
            $groupedRankings = Event::with(['rankings' => function($query) {
                $query->with('participant')->orderBy('rank', 'asc')->orderBy('score', 'desc');
            }])
            ->has('rankings')
            ->orderBy('tanggal_event', 'desc')
            ->get();

            $rankings = Ranking::with(['participant', 'event'])
                             ->orderBy('rank', 'asc')
                             ->orderBy('score', 'desc')
                             ->get();
        }

        return view('rankings.index', compact('rankings', 'events', 'groupedRankings', 'selectedEventId'));
    }

    public function create()
    {
        $participants = Participant::with('event')->get();
        $events = Event::all();
        return view('rankings.create', compact('participants', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'event_id' => 'required|exists:events,id',
            'rank' => 'required|integer|min:1',
            'score' => 'required|numeric|min:0',
            'achievement' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Ranking::create($request->all());

        return redirect()->route('rankings.index')->with('success', 'Ranking berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ranking = Ranking::findOrFail($id);
        $participants = Participant::with('event')->get();
        $events = Event::all();
        return view('rankings.edit', compact('ranking', 'participants', 'events'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'event_id' => 'required|exists:events,id',
            'rank' => 'required|integer|min:1',
            'score' => 'required|numeric|min:0',
            'achievement' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $ranking = Ranking::findOrFail($id);
        $ranking->update($request->all());

        return redirect()->route('rankings.index')->with('success', 'Ranking berhasil diupdate!');
    }

    public function destroy($id)
    {
        Ranking::findOrFail($id)->delete();
        return redirect()->route('rankings.index')->with('success', 'Ranking berhasil dihapus!');
    }
}
