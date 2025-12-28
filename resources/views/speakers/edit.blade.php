@extends('layouts.app')
<head><title>Vettix - Edit Pembicara</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Pembicara</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Perbarui informasi detail untuk {{ $speaker->nama_lengkap }}</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <main class="flex-1 p-10">
        @if ($errors->any())
            <div class="max-w-4xl mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500 mt-1"></i>
                    <div>
                        <p class="font-bold mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('speakers.update', $speaker->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="border border-gray-200 rounded-2xl p-6 flex items-start space-x-6 mb-6 bg-gray-50/30">
                    <img src="{{ $speaker->avatar_url }}" class="w-24 h-24 rounded-full border-4 border-white shadow-sm object-cover">
                    <div class="flex-1 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ $speaker->nama_lengkap }}"
                                class="w-full text-xl font-bold text-gray-800 border-none bg-transparent p-0 focus:ring-0">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Role/Pekerjaan</label>
                                <input type="text" name="role_job" value="{{ $speaker->role_job }}"
                                    class="w-full font-semibold text-gray-700 border-b border-gray-200 focus:border-cyan-500 p-1 focus:ring-0">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Instansi</label>
                                <input type="text" name="instansi" value="{{ $speaker->instansi }}"
                                    class="w-full font-semibold text-gray-700 border-b border-gray-200 focus:border-cyan-500 p-1 focus:ring-0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-bold text-gray-800 mb-3">Deskripsi Bio</label>
                    <textarea name="bio_singkat" rows="5"
                        class="w-full border border-gray-200 rounded-2xl p-4 text-gray-600 leading-relaxed focus:ring-2 focus:ring-cyan-500 focus:border-transparent">{{ $speaker->bio_singkat }}</textarea>
                </div>

                <div class="mb-10">
                    <label class="block font-bold text-gray-800 mb-3">Pilih Event Terkait</label>
                    <select name="event_id" class="w-full border border-gray-200 rounded-xl p-4 bg-white focus:ring-2 focus:ring-cyan-500 outline-none">
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" @if($speaker->event_id == $event->id) selected @endif>
                                {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between items-center border-t pt-8">
                    <a href="{{ route('speakers.index') }}" class="text-gray-400 font-bold hover:text-gray-600 transition">Batal</a>
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-emerald-100 transition-all flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i> Update Data Pembicara
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
