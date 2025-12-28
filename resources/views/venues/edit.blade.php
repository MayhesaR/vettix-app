@extends('layouts.app')
<head><title>Vettix - Edit Venue</title></head>

@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Review</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Ubah detail review</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

@section('content')
<div class="p-8">
    <h2 class="text-xl font-bold mb-6">Edit Ruangan</h2>

    <form action="{{ route('venues.update', $venue->id) }}"
          method="POST"
          class="bg-white p-6 rounded shadow grid grid-cols-2 gap-4">
        @csrf
        @method('PUT')

        <input name="nama_venue" value="{{ $venue->nama_venue }}"
               class="border p-3 rounded">

        <input name="gedung" value="{{ $venue->gedung }}"
               class="border p-3 rounded">

        <input name="kapasitas" value="{{ $venue->kapasitas }}"
               class="border p-3 rounded">

        <input name="fasilitas" value="{{ $venue->fasilitas }}"
               class="border p-3 rounded col-span-2">

        <div class="col-span-2 flex justify-end gap-4 mt-4">
            <a href="{{ route('venues.index') }}" class="px-4 py-2 border rounded">
                Cancel
            </a>
            <button class="bg-teal-500 text-white px-6 py-2 rounded">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
