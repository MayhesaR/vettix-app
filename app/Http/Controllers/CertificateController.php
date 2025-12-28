<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Event;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['participant', 'event'])->get();
        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        $participants = Participant::all();
        $events = Event::all();
        return view('certificates.create', compact('participants', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'event_id' => 'required|exists:events,id',
            'file_path' => 'nullable|string',
        ]);

        $no_sertifikat = 'SR-' . str_pad(Certificate::count() + 1, 3, '0', STR_PAD_LEFT) . '/' . date('Y');

        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($no_sertifikat);

        Certificate::create([
            'no_sertifikat' => $no_sertifikat,
            'qr_code_url'   => $qrUrl,
            'file_path'     => $request->file_path,
            'participant_id' => $request->participant_id,
            'event_id'      => $request->event_id,
        ]);

        return redirect('/certificates')->with('success', 'Sertifikat berhasil dibuat!');
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        $participants = Participant::all();
        $events = Event::all();
        return view('certificates.edit', compact('certificate', 'participants', 'events'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'event_id' => 'required|exists:events,id',
            'file_path' => 'nullable|string',
        ]);

        $cert = Certificate::findOrFail($id);
        
        $cert->update([
            'participant_id' => $request->participant_id,
            'event_id' => $request->event_id,
            'file_path' => $request->file_path,
        ]);

        return redirect('/certificates')->with('success', 'Sertifikat berhasil diupdate!');
    }

    public function destroy($id)
    {
        Certificate::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Sertifikat dihapus!');
    }
}
