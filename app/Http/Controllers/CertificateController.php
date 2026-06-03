<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
        ]);

        $no_sertifikat = 'SR-' . str_pad(Certificate::count() + 1, 3, '0', STR_PAD_LEFT) . '/' . date('Y');
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($no_sertifikat);

        // Fetch participant and event details
        $participant = Participant::findOrFail($request->participant_id);
        $event = Event::findOrFail($request->event_id);

        // Fetch QR Code and convert to Base64 to guarantee offline rendering in PDF
        try {
            $qrCodeData = file_get_contents($qrUrl);
            $qrCodeBase64 = base64_encode($qrCodeData);
        } catch (\Exception $e) {
            // Fallback base64 image (tiny transparent 1x1 png)
            $qrCodeBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        }

        // Render PDF
        $pdf = Pdf::loadView('certificates.pdf', compact('participant', 'event', 'no_sertifikat', 'qrCodeBase64'));
        
        // Ensure destination folder exists under public storage
        Storage::disk('public')->makeDirectory('certificates');

        // Sanitize certificate number for Windows file systems (slashes to dashes)
        $filename = str_replace('/', '-', $no_sertifikat) . '.pdf';
        
        // Save PDF to public storage
        Storage::disk('public')->put('certificates/' . $filename, $pdf->output());

        Certificate::create([
            'no_sertifikat' => $no_sertifikat,
            'qr_code_url'   => $qrUrl,
            'file_path'     => '/storage/certificates/' . $filename,
            'participant_id' => $request->participant_id,
            'event_id'      => $request->event_id,
        ]);

        return redirect('/certificates')->with('success', 'Sertifikat berhasil dibuat dan file PDF diterbitkan!');
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
        ]);

        $cert = Certificate::findOrFail($id);

        // Delete old PDF file
        if ($cert->file_path) {
            $oldPath = str_replace('/storage/', '', $cert->file_path);
            Storage::disk('public')->delete($oldPath);
        }

        // Fetch participant and event details
        $participant = Participant::findOrFail($request->participant_id);
        $event = Event::findOrFail($request->event_id);
        $no_sertifikat = $cert->no_sertifikat;
        $qrUrl = $cert->qr_code_url;

        // Fetch QR Code and convert to Base64
        try {
            $qrCodeData = file_get_contents($qrUrl);
            $qrCodeBase64 = base64_encode($qrCodeData);
        } catch (\Exception $e) {
            $qrCodeBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        }

        // Regenerate PDF
        $pdf = Pdf::loadView('certificates.pdf', compact('participant', 'event', 'no_sertifikat', 'qrCodeBase64'));
        $filename = str_replace('/', '-', $no_sertifikat) . '.pdf';
        Storage::disk('public')->put('certificates/' . $filename, $pdf->output());

        $cert->update([
            'participant_id' => $request->participant_id,
            'event_id' => $request->event_id,
            'file_path' => '/storage/certificates/' . $filename,
        ]);

        return redirect('/certificates')->with('success', 'Sertifikat dan file PDF berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cert = Certificate::findOrFail($id);

        // Delete the physical PDF file
        if ($cert->file_path) {
            $relativePath = str_replace('/storage/', '', $cert->file_path);
            Storage::disk('public')->delete($relativePath);
        }

        $cert->delete();
        
        return redirect()->back()->with('success', 'Sertifikat dan file PDF berhasil dihapus!');
    }
}
