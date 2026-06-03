<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Event;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with('event')->get();
        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        $events = Event::all();
        return view('participants.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peserta' => 'required|string|max:255',
            'nim' => 'required|string|unique:participants,nim|max:255',
            'email' => 'required|email|max:255',
            'asal_instansi' => 'required|string|max:255',
            'status_kehadiran' => 'required|in:hadir,tidak_hadir',
            'event_id' => 'required|exists:events,id',
        ]);

        Participant::create([
            'nama_peserta' => $request->nama_peserta,
            'nim' => $request->nim,
            'email' => $request->email,
            'asal_instansi' => $request->asal_instansi,
            'status_kehadiran' => $request->status_kehadiran,
            'event_id' => $request->event_id,
        ]);

        return redirect('/participants')->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function show($id)
    {
        $participant = Participant::with(['event', 'certificate'])->findOrFail($id);
        return view('participants.show', compact('participant'));
    }

    public function edit($id)
    {
        $participant = Participant::findOrFail($id);
        $events = Event::all();
        return view('participants.edit', compact('participant', 'events'));
    }

    public function update(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $request->validate([
            'nama_peserta' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:participants,nim,' . $id,
            'email' => 'required|email|max:255',
            'asal_instansi' => 'required|string|max:255',
            'status_kehadiran' => 'required|in:hadir,tidak_hadir',
            'event_id' => 'required|exists:events,id',
        ]);

        $participant->update([
            'nama_peserta' => $request->nama_peserta,
            'nim' => $request->nim,
            'email' => $request->email,
            'asal_instansi' => $request->asal_instansi,
            'status_kehadiran' => $request->status_kehadiran,
            'event_id' => $request->event_id,
        ]);

        return redirect('/participants')->with('success', 'Data peserta berhasil diupdate!');
    }

    public function destroy($id)
    {
        Participant::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Peserta berhasil dihapus!');
    }

    public function showSelfRegister($event_id)
    {
        $event = Event::with('venue')->findOrFail($event_id);
        $user = auth()->user();
        
        // Find if they have any previous participant record to prefill NIM and Asal Instansi
        $previousRecord = Participant::where('email', $user->email)->orderBy('created_at', 'desc')->first();
        $prefilledNim = $previousRecord ? $previousRecord->nim : '';
        $prefilledInstansi = $previousRecord ? $previousRecord->asal_instansi : '';
        
        return view('participants.self_register', compact('event', 'user', 'prefilledNim', 'prefilledInstansi'));
    }

    public function selfRegister(Request $request, $event_id)
    {
        $user = auth()->user();
        
        // Check if already registered for this event
        $alreadyRegistered = Participant::where('email', $user->email)->where('event_id', $event_id)->exists();
        if ($alreadyRegistered) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah terdaftar di event ini!');
        }

        $request->validate([
            'nim' => 'required|string|unique:participants,nim|max:255',
            'asal_instansi' => 'required|string|max:255',
        ], [
            'nim.unique' => 'NIM ini sudah digunakan oleh peserta lain!',
        ]);

        Participant::create([
            'nama_peserta' => $user->name,
            'nim' => $request->nim,
            'email' => $user->email,
            'asal_instansi' => $request->asal_instansi,
            'status_kehadiran' => 'tidak_hadir',
            'event_id' => $event_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran event berhasil! Status keikutsertaan Anda telah dicatat.');
    }
}
