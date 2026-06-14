<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Validator;

class EventApiController extends Controller
{

    public function index(Request $request)
    {
        $query = Event::with(['category', 'venue']);

        if ($request->has('search')) {
            $likeOperator = (\DB::connection()->getDriverName() === 'pgsql') ? 'ilike' : 'like';
            $query->where('nama_event', $likeOperator, '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $events = $query->latest()->get();

        return response()->json([
            'status'  => true,
            'message' => 'List Data Events',
            'data'    => EventResource::collection($events)
        ], 200);
    }

    public function show($id)
    {
        $event = Event::with(['category', 'venue'])->find($id);

        if (!$event) {
            return response()->json([
                'status'  => false,
                'message' => 'Event tidak ditemukan',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail Data Event',
            'data'    => new EventResource($event)
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
            'deskripsi'     => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi Gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $event = Event::create([
            'nama_event'    => $request->nama_event,
            'category_id'   => $request->category_id,
            'venue_id'      => $request->venue_id,
            'tanggal_event' => $request->tanggal_event,
            'deskripsi'     => $request->deskripsi,
            'user_id'       => 1,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Event Berhasil Ditambahkan',
            'data'    => new EventResource($event)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['status' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $event->update($request->all());

        return response()->json([
            'status'  => true,
            'message' => 'Event Berhasil Diupdate',
            'data'    => new EventResource($event)
        ], 200);
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['status' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        $event->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Event Berhasil Dihapus'
        ], 200);
    }
}
