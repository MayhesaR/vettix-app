@extends('layouts.app')

<head>
<title>Vettix - Manajemen Event</title>


</head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Event Management</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Manage Event</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection
@include('events.sidebar')


@section('content')
<div class="container-fluid px-0">

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #d1fae5; color: #065f46;">
            <i class="fa-solid fa-circle-check me-2"></i>
            <strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Event Calendar</h5>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('events.index', array_merge(request()->all(), ['month' => $prevMonth])) }}" class="text-dark text-decoration-none">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>

                <span class="fw-bold fs-5 text-dark">{{ $currentMonthName }}</span>

                <a href="{{ route('events.index', array_merge(request()->all(), ['month' => $nextMonth])) }}" class="text-dark text-decoration-none">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless text-center" style="table-layout: fixed;">
                <thead>
                    <tr class="text-muted text-uppercase small" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <th class="pb-3 fw-normal">Sun</th>
                        <th class="pb-3 fw-normal">Mon</th>
                        <th class="pb-3 fw-normal">Tue</th>
                        <th class="pb-3 fw-normal">Wed</th>
                        <th class="pb-3 fw-normal">Thu</th>
                        <th class="pb-3 fw-normal">Fri</th>
                        <th class="pb-3 fw-normal">Sat</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-dark">
                    <tr>
                        {{-- LOGIKA 1: Kotak Kosong Awal Bulan --}}
                        @for ($i = 0; $i < $firstDayOfWeek; $i++)
                            <td></td> {{-- Kosong tanpa bg-light agar bersih --}}
                        @endfor

                        {{-- LOGIKA 2: Loop Tanggal --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $currentDate = $date->copy()->day($day)->format('Y-m-d');
                                $isToday = $currentDate == now()->format('Y-m-d');
                                $dayOfWeek = ($firstDayOfWeek + $day - 1) % 7;
                                $hasEvent = isset($calendarEvents[$currentDate]);
                            @endphp

                            <td class="position-relative py-3 align-middle" style="height: 80px;">
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">

                                    <span class="d-flex align-items-center justify-content-center rounded-circle mb-1
                                        {{ $isToday ? 'bg-primary text-white shadow-sm' : '' }}"
                                        style="width: 35px; height: 35px; cursor: pointer;">
                                        {{ $day }}
                                    </span>

                                    <div class="d-flex gap-1 mt-1" style="height: 6px;">
                                        @if($hasEvent)
                                            @foreach($calendarEvents[$currentDate] as $evt)
                                                @php
                                                    $dotColor = match($evt->category_id) {
                                                        1 => '#ef4444',
                                                        2 => '#84cc16',
                                                        3 => '#06b6d4',
                                                        4 => '#a855f7',
                                                        default => '#cbd5e1'
                                                    };
                                                @endphp
                                                <span class="rounded-circle"
                                                      style="width: 6px; height: 6px; background-color: {{ $dotColor }}; display: inline-block;">
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            </td>

                            {{-- Ganti Baris (Minggu Baru) --}}
                            @if ($dayOfWeek == 6)
                                </tr><tr>
                            @endif
                        @endfor

                        {{-- LOGIKA 3: Kotak Kosong Akhir Bulan --}}
                        @php $remainingDays = 6 - (($firstDayOfWeek + $daysInMonth - 1) % 7); @endphp
                        @for ($i = 0; $i < $remainingDays; $i++)
                            <td></td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-4">

            <div class="d-flex gap-4 small text-muted">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle" style="width:10px; height:10px; background-color: #ef4444;"></span> Seminar
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle" style="width:10px; height:10px; background-color: #84cc16;"></span> Workshop
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle" style="width:10px; height:10px; background-color: #06b6d4;"></span> Kompetisi
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle" style="width:10px; height:10px; background-color: #a855f7;"></span> Konferensi
                </div>
            </div>

            <a href="{{ route('events.export.pdf', ['month' => request('month')]) }}" class="btn fw-bold px-3 py-2 shadow-sm text-decoration-none" style="background-color: #86efac; color: #14532d; border: none; font-size: 0.9rem;">
                <i class="fa-solid fa-file-arrow-down me-2"></i> Export Jadwal
            </a>
        </div>

    </div>
</div>





    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3">
            <form action="{{ route('events.index') }}" method="GET" class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <h5 class="fw-bold mb-0">Semua Event</h5>

                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>
                        <input type="text"
                               name="search"
                               class="form-control border-start-0 ps-0"
                               placeholder="Cari Event..."
                               value="{{ request('search') }}"> </div>

                    <select name="category_id" class="form-select form-select-sm" style="width: 250px;" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach

                    </select>

                    @if(request('category_id') || request('search'))
                        <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-danger pt-2" style="width: 30px;" title="Reset Filter">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase table-secondary">
                        <tr>
                            <th class="ps-4 py-3">Nama Event</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Venue</th>
                            <th class="py-3">Status</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        {{-- LOOPING DATA DARI CONTROLLER --}}
                        @forelse($events as $event)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $event->nama_event }}</td>
                                <td class="text-muted small">{{ \Carbon\Carbon::parse($event->tanggal_event)->format('M d, Y') }}</td>
                                <td>{{ $event->category->nama_kategori ?? '-' }}</td>
                                <td class="text-muted small">{{ $event->venue->nama_venue ?? '-' }}</td>
                                <td>
                                    @if($event->tanggal_event < now())
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Done</span>
                                    @else
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Upcoming</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-link p-0 me-2 text-primary">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-link p-0 text-danger btn-delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $event->id }}"
                                            data-name="{{ $event->nama_event }}">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><p>Tidak ada event ditemukan.</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination footer (Mockup) --}}
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} results
            </small>
            <div>
                {{-- withQueryString() wajib ada agar filter tidak reset saat ganti halaman --}}
                {{ $events->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body text-center">

                <div class="d-flex justify-content-center mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; background-color: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fs-3"></i>
                    </div>
                </div>

                <h5 class="fw-bold mb-2 text-dark">Hapus Event?</h5>
                <p class="text-muted small mb-4">
                    Apakah Anda yakin ingin menghapus <strong id="modal-event-name" class="text-dark">Nama Event</strong>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-white border px-4 fw-bold rounded-3" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 fw-bold rounded-3" style="background-color: #ef4444; border: none;">
                            Ya, Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-id');
                const eventName = this.getAttribute('data-name');

                document.getElementById('modal-event-name').textContent = `"${eventName}"`;

                const form = document.getElementById('deleteForm');
                form.action = `/events/${eventId}`;
            });
        });
    });
</script>
@endsection
