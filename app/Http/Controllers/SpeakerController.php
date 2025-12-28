<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speaker;
use App\Models\Event;
use Illuminate\Support\Facades\Http;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::with('event')->get();
        return view('speakers.index', compact('speakers'));
    }

    public function create()
    {
        $events = Event::all();
        return view('speakers.create', compact('events'));
    }

    public function fetchGithub($username)
    {
        $response = Http::get("https://api.github.com/users/" . $username);

        if ($response->failed()) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $data = $response->json();

        return response()->json([
            'username_platform' => $data['login'] ?? null,
            'nama_lengkap'      => $data['name'] ?? null,
            'bio_singkat'       => $data['bio'] ?? null,
            'avatar_url'        => $data['avatar_url'] ?? null,
            'instansi'          => $data['company'] ?? null,
            'role_job'          => null
        ]);
    }

    public function fetchDevto($username)
    {
        $response = Http::get("https://dev.to/api/users/by_username?url=" . $username);

        if ($response->failed()) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $data = $response->json();

        return response()->json([
            'username_platform' => $data['username'] ?? null,
            'nama_lengkap'      => $data['name'] ?? null,
            'bio_singkat'       => $data['summary'] ?? null,
            'avatar_url'        => $data['profile_image'] ?? null,
            'instansi'          => $data['location'] ?? null,
            'role_job'          => $data['joined_at'] ? 'Developer/Writer' : null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username_platform' => 'nullable|string|max:255',
            'nama_lengkap'      => 'required|string|max:255',
            'role_job'          => 'nullable|string|max:255',
            'instansi'          => 'nullable|string|max:255',
            'bio_singkat'       => 'nullable|string',
            'avatar_url'        => 'nullable|url',
            'event_id'          => 'required|exists:events,id'
        ]);

        Speaker::create($request->all());
        return redirect()->route('speakers.index')->with('success', 'Pembicara berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $speaker = Speaker::findOrFail($id);
        $events = Event::all();
        return view('speakers.edit', compact('speaker', 'events'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username_platform' => 'nullable|string|max:255',
            'nama_lengkap'      => 'required|string|max:255',
            'role_job'          => 'nullable|string|max:255',
            'instansi'          => 'nullable|string|max:255',
            'bio_singkat'       => 'nullable|string',
            'avatar_url'        => 'nullable|url',
            'event_id'          => 'required|exists:events,id'
        ]);

        $speaker = Speaker::findOrFail($id);
        $speaker->update($request->all());
        return redirect()->route('speakers.index')->with('success', 'Data pembicara berhasil diupdate!');
    }

    public function destroy($id)
    {
        Speaker::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pembicara berhasil dihapus!');
    }
}
