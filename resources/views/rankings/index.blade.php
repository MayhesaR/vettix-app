@extends('layouts.app')
<head><title>Vettix - Ranking</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Ranking</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Ranking peserta event</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid px-0">

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #d1fae5; color: #065f46;">
            <i class="fa-solid fa-circle-check me-2"></i>
            <strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-trophy text-warning me-2"></i>Ranking Management</h5>
                    <p class="text-muted small mb-0">Kelola dan lihat ranking peserta per event</p>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <form action="{{ route('rankings.index') }}" method="GET" class="d-flex gap-2">
                        <select name="event_id" class="form-select form-select-sm" style="width: 300px;" onchange="this.form.submit()">
                            <option value="">🏆 Lihat Semua Event</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ $selectedEventId == $event->id ? 'selected' : '' }}>
                                    {{ $event->nama_event }} @if($event->rankings_count > 0)({{ $event->rankings_count }} peserta)@endif
                                </option>
                            @endforeach
                        </select>

                        @if($selectedEventId)
                            <a href="{{ route('rankings.index') }}" class="btn btn-sm btn-outline-danger" title="Reset Filter">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('rankings.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Ranking
                    </a>
                </div>
            </div>
        </div>
    </div>

    @forelse($groupedRankings as $event)
        @if($event->rankings->isNotEmpty())
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="fa-solid fa-calendar-day me-2"></i>{{ $event->nama_event }}</h5>
                        <small><i class="fa-solid fa-clock me-1"></i>{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }} | <i class="fa-solid fa-users me-1"></i>{{ $event->rankings->count() }} Peserta</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white text-dark">{{ $event->category->nama_kategori ?? 'Event' }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row text-center mb-4">
                    @php
                        $topThree = $event->rankings->take(3);
                        $positions = [
                            2 => ['bg' => '#c0c0c0', 'icon' => '🥈', 'label' => '2nd Place'],
                            1 => ['bg' => '#ffd700', 'icon' => '🥇', 'label' => '1st Place'],
                            3 => ['bg' => '#cd7f32', 'icon' => '🥉', 'label' => '3rd Place']
                        ];
                    @endphp

                    @foreach([2, 1, 3] as $position)
                        @php
                            $winner = $topThree->where('rank', $position)->first();
                        @endphp
                        <div class="col-md-4">
                            @if($winner)
                                <div class="p-4 rounded-3 h-100" style="background: linear-gradient(135deg, {{ $positions[$position]['bg'] }}30, {{ $positions[$position]['bg'] }}10); border: 2px solid {{ $positions[$position]['bg'] }};">
                                    <div class="fs-1 mb-2">{{ $positions[$position]['icon'] }}</div>
                                    <div class="fw-bold text-dark fs-5">{{ $winner->participant->nama_peserta ?? '-' }}</div>
                                    <small class="text-muted d-block mb-2">{{ $winner->participant->nim ?? '-' }}</small>
                                    <div class="mt-3">
                                        <span class="badge bg-success fs-6 px-3 py-2">{{ $winner->score }} pts</span>
                                    </div>
                                    @if($winner->achievement)
                                        <div class="mt-2">
                                            <span class="badge bg-warning text-dark">{{ $winner->achievement }}</span>
                                        </div>
                                    @endif
                                    @if($winner->notes)
                                        <p class="text-muted small mt-2 mb-0"><i class="fa-solid fa-lightbulb me-1"></i>{{ Str::limit($winner->notes, 50) }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="p-4 rounded-3 bg-light text-muted border border-dashed">
                                    <div class="fs-1 mb-2">{{ $positions[$position]['icon'] }}</div>
                                    <small>{{ $positions[$position]['label'] }}<br>Belum ada pemenang</small>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($event->rankings->count() > 3)
                <div class="mt-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-list-ol me-2"></i>Full Rankings</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3" style="width: 80px;">Rank</th>
                                    <th>Peserta</th>
                                    <th>NIM</th>
                                    <th>Score</th>
                                    <th>Achievement</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->rankings as $ranking)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white
                                                {{ $ranking->rank == 1 ? 'bg-warning' : ($ranking->rank == 2 ? 'bg-secondary' : ($ranking->rank == 3 ? 'bg-danger' : 'bg-primary')) }}"
                                                style="width: 40px; height: 40px;">
                                                #{{ $ranking->rank }}
                                            </div>
                                        </td>
                                        <td class="fw-bold">{{ $ranking->participant->nama_peserta ?? '-' }}</td>
                                        <td class="text-muted small">{{ $ranking->participant->nim ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                                {{ $ranking->score }} pts
                                            </span>
                                        </td>
                                        <td>
                                            @if($ranking->achievement)
                                                <span class="badge bg-warning text-dark">{{ $ranking->achievement }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('rankings.edit', $ranking->id) }}" class="btn btn-link p-0 me-2 text-primary">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-link p-0 text-danger btn-delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal"
                                                    data-id="{{ $ranking->id }}"
                                                    data-name="{{ $ranking->participant->nama_peserta ?? 'Ranking' }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    @empty
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-5 text-center">
                <i class="fa-solid fa-trophy fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data ranking</h5>
                <p class="text-muted">Mulai tambahkan ranking untuk event Anda</p>
                <a href="{{ route('rankings.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Tambah Ranking Pertama
                </a>
            </div>
        </div>
    @endforelse

    <div class="card border-0 shadow-sm rounded-3 d-none">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">All Rankings</h5>

                <div class="d-flex gap-2">

                    <a href="{{ route('rankings.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Ranking
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase table-secondary">
                        <tr>
                            <th class="ps-4 py-3" style="width: 80px;">Rank</th>
                            <th class="py-3">Peserta</th>
                            <th class="py-3">NIM</th>
                            <th class="py-3">Event</th>
                            <th class="py-3">Score</th>
                            <th class="py-3">Achievement</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($rankings as $ranking)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white
                                        {{ $ranking->rank == 1 ? 'bg-warning' : ($ranking->rank == 2 ? 'bg-secondary' : ($ranking->rank == 3 ? 'bg-danger' : 'bg-primary')) }}"
                                        style="width: 40px; height: 40px;">
                                        #{{ $ranking->rank }}
                                    </div>
                                </td>
                                <td class="fw-bold text-dark">{{ $ranking->participant->nama_peserta ?? '-' }}</td>
                                <td class="text-muted small">{{ $ranking->participant->nim ?? '-' }}</td>
                                <td class="text-muted small">{{ $ranking->event->nama_event ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                        {{ $ranking->score }} pts
                                    </span>
                                </td>
                                <td>
                                    @if($ranking->achievement)
                                        <span class="badge bg-warning text-dark">{{ $ranking->achievement }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('rankings.edit', $ranking->id) }}" class="btn btn-link p-0 me-2 text-primary">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-link p-0 text-danger btn-delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $ranking->id }}"
                                            data-name="{{ $ranking->participant->nama_peserta ?? 'Ranking' }}">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fa-solid fa-trophy fs-1 text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data ranking. <a href="{{ route('rankings.create') }}">Tambah ranking pertama</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

                <h5 class="fw-bold mb-2 text-dark">Hapus Ranking?</h5>
                <p class="text-muted small mb-4">
                    Apakah Anda yakin ingin menghapus ranking untuk <strong id="modal-ranking-name" class="text-dark">Peserta</strong>?
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
                const rankingId = this.getAttribute('data-id');
                const rankingName = this.getAttribute('data-name');

                document.getElementById('modal-ranking-name').textContent = `"${rankingName}"`;

                const form = document.getElementById('deleteForm');
                form.action = `/rankings/${rankingId}`;
            });
        });
    });
</script>
@endsection
