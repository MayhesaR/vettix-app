<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VenueApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Venue::all()
        ]);
    }

    public function show($id)
    {
        $venue = Venue::find($id);
        if (!$venue) {
            return response()->json(['success' => false], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $venue
        ]);
    }

    public function store(Request $request)
    {
        $venue = Venue::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $venue
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);
        $venue->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $venue
        ]);
    }

    public function destroy($id)
    {
        Venue::destroy($id);

        return response()->json([
            'success' => true
        ]);
    }
}
