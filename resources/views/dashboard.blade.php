@extends('layouts.app')

@section('title-text', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">

    @if(Auth::user()->role === 'admin')
        <!-- Page Header Info & Action -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Selamat datang kembali!</h4>
                <div class="text-muted small">Ringkasan aktivitas dan data terbaru platform Anda</div>
            </div>
            <div>
                <a href="{{ route('events.create') }}" class="btn-brand text-decoration-none">
                    <i class="fa-solid fa-plus"></i>
                    <span>Event Baru</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-3 mb-4">
            <!-- Total Event Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small mb-1">Total Event</div>
                                <div class="fw-bold fs-3 text-slate-800">{{ $stats['events'] }}</div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #e0f2fe; color: #0369a1;">
                                <i class="fa-solid fa-calendar-days fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peserta Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small mb-1">Peserta Terdaftar</div>
                                <div class="fw-bold fs-3 text-slate-800">{{ $stats['participants'] }}</div>
                                <div class="text-muted mt-1" style="font-size: 11px;">
                                    Hadir: <span class="text-success fw-semibold">{{ $hadir }}</span> | Absen: <span class="text-danger fw-semibold">{{ $tidakHadir }}</span>
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #fef3c7; color: #b45309;">
                                <i class="fa-solid fa-users fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Card -->
            <div class="col-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small mb-1">Reviews Masuk</div>
                                <div class="fw-bold fs-3 text-slate-800">{{ $stats['reviews'] }}</div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #fee2e2; color: #b91c1c;">
                                <i class="fa-regular fa-comment-dots fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main List Grids -->
        <div class="row g-4 mb-4">
            <!-- Upcoming Events -->
            <div class="col-lg-6">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-clock text-slate-400"></i>
                        <span>Upcoming Events</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($upcomingEvents as $evt)
                                <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4 border-0 border-bottom">
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $evt->nama_event }}</div>
                                        <div class="text-muted mt-1" style="font-size: 12px;">
                                            <span class="me-2"><i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($evt->tanggal_event)->format('d M Y') }}</span>
                                            @if($evt->venue)
                                                <span class="me-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $evt->venue->nama_venue }}</span>
                                            @endif
                                            @if($evt->category)
                                                <span class="badge badge-brand">{{ $evt->category->nama_kategori }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ route('events.edit', $evt->id) }}" class="btn btn-outline-brand btn-sm py-1 px-3">Kelola</a>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-regular fa-calendar-minus d-block fs-3 mb-2 text-slate-300"></i>
                                    Tidak ada event mendatang.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="col-lg-6">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-star text-warning"></i>
                        <span>Recent Reviews</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentReviews as $review)
                                <div class="list-group-item d-flex align-items-start justify-content-between py-3 px-4 border-0 border-bottom">
                                    <div class="d-flex gap-3">
                                        <img src="{{ $review->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($review->participant_name ?? 'P') }}" alt="Avatar" style="width:38px; height:38px;" class="rounded-circle border">
                                        <div>
                                            <div class="fw-bold text-slate-800">{{ $review->participant_name }}</div>
                                            <div class="text-muted small">{{ $review->event->nama_event ?? '-' }}</div>
                                            <div class="text-warning mt-0.5">
                                                @for($i=1; $i<=5; $i++)
                                                    @if($i <= $review->rating) ★ @else <span class="text-slate-300">★</span> @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-brand btn-sm py-1 px-3">Lihat</a>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-regular fa-comment-slash d-block fs-3 mb-2 text-slate-300"></i>
                                    Belum ada review masuk.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary List Grids -->
        <div class="row g-4">
            <!-- Latest Certificates -->
            <div class="col-lg-6">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-certificate text-slate-400"></i>
                        <span>Latest Certificates</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentCertificates as $cert)
                                <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4 border-0 border-bottom">
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $cert->participant->nama_peserta ?? '-' }}</div>
                                        <div class="text-muted small mt-0.5">
                                            <span>{{ $cert->event->nama_event ?? '-' }}</span>
                                            <span class="mx-1.5">•</span>
                                            <code class="text-brand font-semibold">{{ $cert->no_sertifikat }}</code>
                                        </div>
                                    </div>
                                    @if($cert->qr_code_url)
                                        <img src="{{ $cert->qr_code_url }}" alt="QR" style="width:34px; height:34px; border: 1px solid var(--border-color);" class="rounded p-0.5 bg-white shadow-sm">
                                    @endif
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-regular fa-file-excel d-block fs-3 mb-2 text-slate-300"></i>
                                    Belum ada sertifikat terbit.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rankings Snapshot -->
            <div class="col-lg-6">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-ranking-star text-slate-400"></i>
                        <span>Rankings Snapshot</span>
                    </div>
                    <div class="card-body p-4">
                        @forelse($rankingEvents as $evt)
                            <div class="mb-4 last:mb-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-bold text-slate-800">{{ $evt->nama_event }}</div>
                                    <a href="{{ route('rankings.index', ['event_id' => $evt->id]) }}" class="btn btn-outline-brand btn-sm py-1 px-3">Detail</a>
                                </div>
                                <div class="row g-2">
                                    @php $topThree = $evt->rankings->take(3); @endphp
                                    @foreach($topThree as $r)
                                        <div class="col-4">
                                            <div class="p-2 border rounded-3 text-center bg-light/50">
                                                <div class="small fw-bold text-slate-500">Rank #{{ $r->rank }}</div>
                                                <div class="fw-semibold text-slate-800 text-truncate mt-0.5" title="{{ $r->participant->nama_peserta ?? '-' }}">{{ $r->participant->nama_peserta ?? '-' }}</div>
                                                <div class="small text-success fw-bold">{{ $r->score }} pts</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fa-solid fa-trophy d-block fs-3 mb-2 text-slate-300"></i>
                                Belum ada ranking tercatat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Participant Dashboard -->
        <!-- Page Header Info -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Selamat datang, {{ Auth::user()->name }}!</h4>
                <div class="text-muted small">Kelola pendaftaran event dan sertifikat Anda di sini</div>
            </div>
        </div>

        <!-- Success/Error Notification -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-left: 4px solid #10b981 !important; background-color: #f0fdf4;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check text-success fs-5"></i>
                    <span class="text-slate-800 fw-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-left: 4px solid #ef4444 !important; background-color: #fef2f2;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                    <span class="text-slate-800 fw-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats Cards Row -->
        <div class="row g-3 mb-4">
            <!-- Total Events Registered -->
            <div class="col-12 col-sm-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small mb-1">Event Diikuti</div>
                                <div class="fw-bold fs-3 text-slate-800">{{ $stats['my_events'] }}</div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #e0f2fe; color: #0369a1;">
                                <i class="fa-solid fa-calendar-days fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Certificates Issued -->
            <div class="col-12 col-sm-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="text-muted small mb-1">Sertifikat Saya</div>
                                <div class="fw-bold fs-3 text-slate-800">{{ $stats['my_certificates'] }}</div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #fef3c7; color: #b45309;">
                                <i class="fa-solid fa-certificate fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lists Grid -->
        <div class="row g-4">
            <!-- My Registered Events List -->
            <div class="col-lg-6">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-slate-400"></i>
                        <span>Event Terdaftar</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($myRegistrations as $reg)
                                <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4 border-0 border-bottom">
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $reg->event->nama_event }}</div>
                                        <div class="text-muted mt-1" style="font-size: 12px;">
                                            <span class="me-2"><i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($reg->event->tanggal_event)->format('d M Y') }}</span>
                                            @if($reg->event->venue)
                                                <span class="me-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $reg->event->venue->nama_venue }}</span>
                                            @endif
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge bg-{{ $reg->status_kehadiran == 'hadir' ? 'success' : 'secondary' }}">
                                                Kehadiran: {{ $reg->status_kehadiran == 'hadir' ? 'Hadir' : 'Belum Hadir / Absen' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        @if($reg->certificate)
                                            <a href="{{ asset($reg->certificate->file_path) }}" class="btn btn-outline-brand btn-sm" target="_blank">
                                                <i class="fa-solid fa-file-pdf me-1"></i> Sertifikat
                                            </a>
                                        @else
                                            <span class="text-muted small" style="font-size: 11px; font-style: italic;">Sertifikat belum terbit</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-solid fa-calendar-xmark d-block fs-3 mb-2 text-slate-300"></i>
                                    Anda belum terdaftar pada event apa pun.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Events List -->
            <div class="col-lg-6">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-compass text-slate-400"></i>
                        <span>Event yang Tersedia</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($availableEvents as $evt)
                                <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4 border-0 border-bottom">
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $evt->nama_event }}</div>
                                        <div class="text-muted mt-1" style="font-size: 12px;">
                                            <span class="me-2"><i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($evt->tanggal_event)->format('d M Y') }}</span>
                                            @if($evt->venue)
                                                <span class="me-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $evt->venue->nama_venue }}</span>
                                            @endif
                                            @if($evt->category)
                                                <span class="badge badge-brand">{{ $evt->category->nama_kategori }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ route('participants.self-register.form', $evt->id) }}" class="btn btn-brand btn-sm">
                                        Daftar Event
                                    </a>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-regular fa-calendar-minus d-block fs-3 mb-2 text-slate-300"></i>
                                    Tidak ada event baru yang tersedia untuk diikuti saat ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
