<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Participant;
use App\Models\Certificate;
use App\Models\Speaker;
use App\Models\Review;
use App\Models\Ranking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'events' => Event::count(),
            'venues' => Venue::count(),
            'participants' => Participant::count(),
            'certificates' => Certificate::count(),
            'speakers' => Speaker::count(),
            'reviews' => Review::count(),
            'rankings' => Ranking::count(),
        ];

        $hadir = Participant::where('status_kehadiran', 'hadir')->count();
        $tidakHadir = Participant::where('status_kehadiran', 'tidak_hadir')->count();

        $upcomingEvents = Event::with(['venue', 'category'])
            ->whereDate('tanggal_event', '>=', now()->toDateString())
            ->orderBy('tanggal_event', 'asc')
            ->take(5)
            ->get();

        $recentReviews = Review::with('event')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentCertificates = Certificate::with(['participant', 'event'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $rankingEvents = Event::with(['rankings' => function ($q) {
                $q->with('participant')->orderBy('rank', 'asc')->orderBy('score', 'desc');
            }])
            ->has('rankings')
            ->orderBy('tanggal_event', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'stats',
            'hadir',
            'tidakHadir',
            'upcomingEvents',
            'recentReviews',
            'recentCertificates',
            'rankingEvents'
        ));
    }
}
