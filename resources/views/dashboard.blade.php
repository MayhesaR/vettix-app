@extends('layouts.app')
<head><title>Vettix - Dashboard</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
    <div>
        <h4 class="fw-bold text-dark mb-0">Dashboard</h4>
        <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Ringkasan aktivitas dan data terbaru</h4>
    </div>
    <div class="ms-auto">
        <a href="{{ route('events.create') }}" class="btn btn-sm" style="background-color: #00c2cb; color: white;"><i class="fa-solid fa-plus me-1"></i> Event Baru</a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Total Event</div>
                            <div class="fw-bold fs-4">{{ $stats['events'] }}</div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e0f2fe;color:#0369a1;">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Peserta</div>
                            <div class="fw-bold fs-4">{{ $stats['participants'] }}</div>
                            <small class="text-muted">Hadir: {{ $hadir }} | Tidak hadir: {{ $tidakHadir }}</small>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#fef3c7;color:#92400e;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Reviews</div>
                            <div class="fw-bold fs-4">{{ $stats['reviews'] }}</div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#fee2e2;color:#b91c1c;">
                            <i class="fa-regular fa-comment-dots"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white fw-bold">Upcoming Events</div>
                <div class="card-body">
                    @forelse($upcomingEvents as $evt)
                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                            <div>
                                <div class="fw-bold">{{ $evt->nama_event }}</div>
                                <small class="text-muted">
                                    <i class="fa-solid fa-calendar-day me-1"></i>{{ \Carbon\Carbon::parse($evt->tanggal_event)->format('d M Y') }}
                                    @if($evt->venue) • <i class="fa-solid fa-location-dot me-1"></i>{{ $evt->venue->nama_venue }} @endif
                                    @if($evt->category) • <span class="badge bg-light text-dark">{{ $evt->category->nama_kategori }}</span> @endif
                                </small>
                            </div>
                            <a href="{{ route('events.edit', $evt->id) }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada event mendatang.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white fw-bold">Recent Reviews</div>
                <div class="card-body">
                    @forelse($recentReviews as $review)
                        <div class="d-flex align-items-start justify-content-between py-2 border-bottom">
                            <div class="d-flex gap-3">
                                <img src="{{ $review->avatar_url }}" alt="Avatar" style="width:40px;height:40px;" class="rounded-circle">
                                <div>
                                    <div class="fw-bold">{{ $review->participant_name }}</div>
                                    <div class="small text-muted">{{ $review->event->nama_event ?? '-' }}</div>
                                    <div class="text-warning">
                                        @for($i=1;$i<=5;$i++)
                                            @if($i <= $review->rating) ★ @else <span class="text-muted">★</span> @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada review.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white fw-bold">Latest Certificates</div>
                <div class="card-body">
                    @forelse($recentCertificates as $cert)
                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                            <div>
                                <div class="fw-bold">{{ $cert->participant->nama_peserta ?? '-' }}</div>
                                <small class="text-muted">{{ $cert->event->nama_event ?? '-' }} - {{ $cert->no_sertifikat }}</small>
                            </div>
                            @if($cert->qr_code_url)
                                <img src="{{ $cert->qr_code_url }}" alt="QR" style="width:34px;height:34px;" class="rounded">
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Belum ada sertifikat.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white fw-bold">Rankings Snapshot</div>
                <div class="card-body">
                    @forelse($rankingEvents as $evt)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold">{{ $evt->nama_event }}</div>
                                <a href="{{ route('rankings.index', ['event_id' => $evt->id]) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                @php $topThree = $evt->rankings->take(3); @endphp
                                @foreach($topThree as $i => $r)
                                    <div class="p-2 border rounded-3 flex-grow-1">
                                        <div class="small text-muted">#{{ $r->rank }}</div>
                                        <div class="fw-bold">{{ $r->participant->nama_peserta ?? '-' }}</div>
                                        <div class="small text-success">{{ $r->score }} pts</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada ranking.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
