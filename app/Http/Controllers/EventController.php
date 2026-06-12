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
use Barryvdh\DomPDF\Facade\Pdf;

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

    $query = Event::with(['category', 'venue', 'user'])->latest();

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
        $rules = [
            'nama_event'    => 'required|string|max:255',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
            'deskripsi'     => 'required|string',
        ];

        if ($request->category_id === 'new') {
            $rules['new_category'] = 'required|string|max:255|unique:categories,nama_kategori';
        } else {
            $rules['category_id'] = 'required|exists:categories,id';
        }

        $request->validate($rules, [
            'nama_event.required'    => 'Nama event wajib diisi.',
            'category_id.required'   => 'Kategori wajib dipilih.',
            'new_category.required'  => 'Nama kategori baru wajib diisi.',
            'new_category.unique'    => 'Kategori tersebut sudah ada.',
            'venue_id.required'      => 'Lokasi (Venue) wajib dipilih.',
            'venue_id.exists'        => 'Lokasi yang dipilih tidak valid.',
            'tanggal_event.required' => 'Tanggal pelaksanaan event wajib diisi.',
            'tanggal_event.date'     => 'Format tanggal tidak valid.',
            'deskripsi.required'     => 'Deskripsi event wajib diisi.',
        ]);

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
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                throw $e;
            }
        }

        try {
            $categoryId = $request->category_id;
            if ($request->category_id === 'new') {
                $category = Category::create([
                    'nama_kategori' => $request->new_category,
                ]);
                $categoryId = $category->id;
            }

            Event::create([
                'nama_event'    => $request->nama_event,
                'category_id'   => $categoryId,
                'venue_id'      => $request->venue_id,
                'tanggal_event' => $request->tanggal_event,
                'deskripsi'     => $request->deskripsi,
                'user_id'       => Auth::id() ?? 1,
            ]);

            return redirect()->route('events.index')->with('success', 'Event berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan event! Alasan: ' . $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        $venues = Venue::all();

        return view('events.edit', compact('event', 'categories', 'venues'));
    }

    public function update(Request $request, Event $event)
    {
        $rules = [
            'nama_event'    => 'required|string|max:255',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
            'deskripsi'     => 'required|string',
        ];

        if ($request->category_id === 'new') {
            $rules['new_category'] = 'required|string|max:255|unique:categories,nama_kategori';
        } else {
            $rules['category_id'] = 'required|exists:categories,id';
        }

        $request->validate($rules, [
            'nama_event.required'    => 'Nama event wajib diisi.',
            'category_id.required'   => 'Kategori wajib dipilih.',
            'new_category.required'  => 'Nama kategori baru wajib diisi.',
            'new_category.unique'    => 'Kategori tersebut sudah ada.',
            'venue_id.required'      => 'Lokasi (Venue) wajib dipilih.',
            'venue_id.exists'        => 'Lokasi yang dipilih tidak valid.',
            'tanggal_event.required' => 'Tanggal pelaksanaan event wajib diisi.',
            'tanggal_event.date'     => 'Format tanggal tidak valid.',
            'deskripsi.required'     => 'Deskripsi event wajib diisi.',
        ]);

        if ($request->tanggal_event != $event->tanggal_event) {
            $dateInput = $request->tanggal_event;
            try {
                $response = Http::timeout(3)->get("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json");
                if ($response->successful()) {
                    $holidays = $response->json();
                    if (isset($holidays[$dateInput])) {
                        $rawSummary = $holidays[$dateInput]['summary'];
                        $namaLibur = is_array($rawSummary) ? $rawSummary[0] : $rawSummary;
                        throw ValidationException::withMessages([
                            'tanggal_event' => "Gagal update! Tanggal $dateInput adalah hari libur: $namaLibur."
                        ]);
                    }
                }
            } catch (\Exception $e) {
                if ($e instanceof ValidationException) {
                    throw $e;
                }
            }
        }

        try {
            $categoryId = $request->category_id;
            if ($request->category_id === 'new') {
                $category = Category::create([
                    'nama_kategori' => $request->new_category,
                ]);
                $categoryId = $category->id;
            }

            $event->update([
                'nama_event'    => $request->nama_event,
                'category_id'   => $categoryId,
                'venue_id'      => $request->venue_id,
                'tanggal_event' => $request->tanggal_event,
                'deskripsi'     => $request->deskripsi,
            ]);

            return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui event! Alasan: ' . $e->getMessage());
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        try {
            $date = $request->has('month')
                ? Carbon::createFromFormat('Y-m', $request->month)
                : Carbon::now();
        } catch (\Exception $e) {
            $date = Carbon::now();
        }

        $currentMonthName = $date->format('F Y');

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $events = Event::with(['category', 'venue'])
            ->whereBetween('tanggal_event', [$startOfMonth, $endOfMonth])
            ->orderBy('tanggal_event', 'asc')
            ->get();

        $pdf = Pdf::loadView('events.pdf_export', compact('events', 'currentMonthName'));

        return $pdf->download('Jadwal_Event_' . str_replace(' ', '_', $currentMonthName) . '.pdf');
    }
}
