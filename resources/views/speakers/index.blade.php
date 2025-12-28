@extends('layouts.app')
<head><title>Vettix - Pembicara</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Pembicara</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Manajemen pembicara</h4>
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
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-10">
            <a href="{{ route('speakers.create') }}" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-cyan-200 transition-all flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Pembicara
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($speakers as $speaker)
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="{{ $speaker->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($speaker->nama_lengkap) }}" class="w-16 h-16 rounded-full border-2 border-cyan-100 object-cover">
                    <div>
                        <h4 class="font-bold text-gray-800 leading-tight">{{ $speaker->nama_lengkap }}</h4>
                        <p class="text-xs text-cyan-600 font-semibold">{{ $speaker->role_job }}</p>
                    </div>
                </div>

                <div class="text-sm text-gray-500 space-y-2 mb-6">
                    <p><i class="fas fa-building mr-2 text-gray-300"></i> {{ $speaker->instansi }}</p>
                    <p><i class="fas fa-calendar-alt mr-2 text-gray-300"></i> Event: <span class="text-gray-700">{{ $speaker->event->nama_event ?? '-' }}</span></p>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                    <a href="{{ route('speakers.edit', $speaker->id) }}" class="text-blue-500 hover:text-blue-700 font-bold text-sm">Edit Profil</a>

                    <form action="{{ route('speakers.destroy', $speaker->id) }}" method="POST" onsubmit="return confirm('Hapus pembicara ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 p-2">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-3 bg-white rounded-3xl border border-gray-100 p-12 text-center">
                <i class="fas fa-microphone text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Pembicara</h3>
                <p class="text-gray-500 mb-6">Mulai tambahkan pembicara untuk event Anda</p>
                <a href="{{ route('speakers.create') }}" class="inline-flex items-center bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition-all">
                    <i class="fas fa-plus mr-2"></i> Tambah Pembicara Pertama
                </a>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
