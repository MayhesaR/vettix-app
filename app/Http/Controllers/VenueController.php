<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use Barryvdh\DomPDF\Facade\Pdf;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        return view('venues.index', compact('venues'));
    }

    public function create()
    {
        return view('venues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_venue'   => 'required|string|max:255',
            'gedung'       => 'required|string|max:255',
            'provinsi_id'  => 'required',
            'kota_id'      => 'required',
            'kecamatan_id' => 'required',
            'kapasitas'    => 'required|integer',
            'fasilitas'    => 'nullable|string',
        ]);

        Venue::create([
            'nama_venue'   => $request->nama_venue,
            'gedung'       => $request->gedung,
            'provinsi_id'  => $request->provinsi_id,
            'kota_id'      => $request->kota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kapasitas'    => $request->kapasitas,
            'fasilitas'    => $request->fasilitas,
        ]);

        return redirect()->route('venues.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('venues.edit', compact('venue'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_venue'   => 'required|string|max:255',
            'gedung'       => 'required|string|max:255',
            'provinsi_id'  => 'required',
            'kota_id'      => 'required',
            'kecamatan_id' => 'required',
            'kapasitas'    => 'required|integer',
            'fasilitas'    => 'nullable|string',
        ]);

        $venue = Venue::findOrFail($id);
        $venue->update($request->all());

        return redirect()->route('venues.index')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Ruangan berhasil dihapus!');
    }

    public function exportPdf()
    {
        $venues = Venue::all();
        $pdf = Pdf::loadView('venues.pdf_export', compact('venues'));
        return $pdf->download('Daftar_Venue_Kampus.pdf');
    }
}
