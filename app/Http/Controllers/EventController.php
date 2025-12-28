<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category; // Wajib: Import Model Kategori
use App\Models\Venue;    // Wajib: Import Model Venue
use Illuminate\Support\Facades\Auth; // Untuk ambil ID user login
use Carbon\Carbon;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    public function index(Request $request)
{

    $date = $request->has('month')
            ? Carbon::createFromFormat('Y-m', $request->month)
            : Carbon::now();

    $prevMonth = $date->copy()->subMonth()->format('Y-m');
    $nextMonth = $date->copy()->addMonth()->format('Y-m');
    $currentMonthName = $date->format('F Y');

    $startOfMonth = $date->copy()->startOfMonth();
    $endOfMonth = $date->copy()->endOfMonth();

    $firstDayOfWeek = $startOfMonth->dayOfWeek;
    $daysInMonth = $date->daysInMonth;

    $calendarEvents = Event::whereBetween('tanggal_event', [$startOfMonth, $endOfMonth])
                        ->get()
                        ->groupBy(function($item) {
                            return $item->tanggal_event;
                        });

    $query = Event::with(['category', 'venue'])->latest();

    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }

    if ($request->has('search') && $request->search != '') {
        $query->where('nama_event', 'like', '%' . $request->search . '%');
    }

    $events = $query->paginate(5);

    $categories = Category::all();

    return view('events.index', compact(
        'events', 'categories',
        'calendarEvents', 'firstDayOfWeek', 'daysInMonth', 'date',
        'prevMonth', 'nextMonth', 'currentMonthName'
    ));

}

    public function create()
    {
        $categories = Category::all();
        $venues = Venue::all();

        return view('events.create', compact('categories', 'venues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
            'deskripsi'     => 'nullable|string',
        ]);

        $year = date('Y', strtotime($request->tanggal_event));
        $dateInput = $request->tanggal_event;

        try {
            $response = Http::get("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json");

            if ($response->successful()) {
                $holidays = $response->json();

                if (isset($holidays[$dateInput])) {
                    $rawSummary = $holidays[$dateInput]['summary'];
                    $namaLibur = is_array($rawSummary) ? $rawSummary[0] : $rawSummary;

                    throw ValidationException::withMessages([
                        'tanggal_event' => "Gagal disimpan! Tanggal $dateInput adalah hari libur: $namaLibur."
                    ]);
                }
            }
        }catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                throw $e;
            }
        }

        Event::create([
            'nama_event'    => $request->nama_event,
            'category_id'   => $request->category_id,
            'venue_id'      => $request->venue_id,
            'tanggal_event' => $request->tanggal_event,
            'deskripsi'     => $request->deskripsi,
            'user_id'       => Auth::id() ?? 1,
        ]);
    return redirect()->route('events.index')->with('success', 'Event berhasil disimpan!');
}

    public function edit(Event $event)
    {
        $categories = Category::all();
        $venues = Venue::all();

        return view('events.edit', compact('event', 'categories', 'venues'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required',
            'venue_id'      => 'required',
            'tanggal_event' => 'required|date',
        ]);

        if ($request->tanggal_event != $event->tanggal_event) {
            $dateInput = $request->tanggal_event;
            try {
                $response = Http::timeout(3)->get("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json");
                if ($response->successful()) {
                    $holidays = $response->json();
                    if (isset($holidays[$dateInput])) {
                        $namaLibur = $holidays[$dateInput]['summary'];
                        throw ValidationException::withMessages([
                            'tanggal_event' => "Gagal update! Tanggal $dateInput adalah hari libur: $namaLibur."
                        ]);
                    }
                }
            } catch (\Exception $e) {
                if ($e instanceof ValidationException) throw $e;
            }
        }

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
