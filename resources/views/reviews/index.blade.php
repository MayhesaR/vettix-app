@extends('layouts.app')

{{-- ================= TITLE ================= --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Manajemen Review</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>

@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Event Feedback & Reviews</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Kelola ulasan dan rating peserta</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

@section('content')
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">



        <main class="ml-2 flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">List Review</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Rata-rata Rating</p>
                        <div class="flex items-center justify-end">
                            <span class="text-yellow-400 text-xl mr-1">★</span>
                            <span class="text-lg font-bold">{{ number_format($avgRating, 1) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('reviews.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Review
                    </a>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-6">
                <form action="{{ route('reviews.index') }}" method="GET" class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">Filter by Event:</label>
                    <select name="event_id" class="form-select rounded-lg border-gray-300 text-sm" style="width: 300px;" onchange="this.form.submit()">
                        <option value="">🔍 Semua Event</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>

                    @if(request('event_id'))
                        <a href="{{ route('reviews.index') }}" class="text-xs px-3 py-2 bg-red-50 text-red-600 rounded border border-red-200 hover:bg-red-100">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif

                    @if(request('event_id'))
                        @php
                            $selectedEvent = $events->find(request('event_id'));
                        @endphp
                        <span class="text-sm text-gray-600">
                            Menampilkan {{ $reviews->total() }} review untuk <strong>{{ $selectedEvent->nama_event ?? 'Event' }}</strong>
                        </span>
                    @endif
                </form>
            </div>

            @if(session('success'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="space-y-6">
                @forelse($reviews as $review)
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div class="flex space-x-4">
                            <img src="{{ $review->avatar_url }}" alt="Avatar" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $review->participant_name }}</h3>
                                <p class="text-xs text-blue-600 font-medium">
                                    <i class="fa-solid fa-calendar-day mr-1"></i>{{ $review->event->nama_event ?? 'No Event' }}
                                </p>
                                <div class="flex text-yellow-400 text-sm my-1">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $review->rating) ★ @else <span class="text-gray-300">★</span> @endif
                                    @endfor
                                </div>
                                <p class="text-gray-600 mt-2">{{ $review->komentar }}</p>
                                <span class="inline-block mt-2 text-xs px-2 py-1 rounded {{ $review->is_published ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500' }}">
                                    Status: {{ $review->is_published ? 'Published' : 'Hidden' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <span class="text-xs text-gray-400 text-right">{{ $review->created_at->diffForHumans() }}</span>
                            <div class="flex space-x-2 mt-2">
                                <form action="{{ route('reviews.toggle', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs px-3 py-1 rounded border {{ $review->is_published ? 'border-yellow-300 text-yellow-600 hover:bg-yellow-50' : 'border-green-300 text-green-600 hover:bg-green-50' }}">
                                        {{ $review->is_published ? 'Sembunyikan' : 'Tampilkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus review ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs px-3 py-1 bg-red-50 text-red-600 rounded border border-red-200 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada ulasan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
               @if ($reviews->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                        {{-- Previous Page Link --}}
                        @if ($reviews->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                &laquo; Previous
                            </span>
                        @else
                            <a href="{{ $reviews->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                &laquo; Previous
                            </a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($reviews->hasMorePages())
                            <a href="{{ $reviews->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                Next &raquo;
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                Next &raquo;
                            </span>
                        @endif
                    </nav>
                @endif
            </div>
        </main>
    </div>
</body>
@endsection
</html>
