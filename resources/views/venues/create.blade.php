@extends('layouts.app')

@section('content')

<div class="ml-64 p-8">
    <h2 class="text-xl font-bold mb-6">Tambah Ruangan</h2>

    <form action="{{ route('venues.store') }}" method="POST"
          class="bg-white p-6 rounded shadow grid grid-cols-2 gap-4">
        @csrf

        <input name="nama_venue" placeholder="Nama Ruangan" class="border p-3 rounded">
        <input name="gedung" placeholder="Gedung" class="border p-3 rounded">

        <select name="provinsi_id" class="border p-3 rounded">
            <option>Pilih Provinsi</option>
        </select>

        <select name="kota_id" class="border p-3 rounded">
            <option>Pilih Kota</option>
        </select>

        <select name="kecamatan_id" class="border p-3 rounded">
            <option>Pilih Kecamatan</option>
        </select>

        <input name="kapasitas" placeholder="Kapasitas" class="border p-3 rounded">
        <input name="fasilitas" placeholder="Fasilitas (WiFi, AC)" class="border p-3 rounded col-span-2">

        <div class="col-span-2 flex justify-end gap-4 mt-4">
            <a href="{{ route('venues.index') }}" class="px-4 py-2 border rounded">
                Cancel
            </a>
            <button class="bg-teal-500 text-white px-6 py-2 rounded">
                Tambah Ruangan
            </button>
        </div>
    </form>
</div>
@endsection
