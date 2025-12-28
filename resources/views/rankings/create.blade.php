@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <head><title>Vettix - Ranking</title></head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Tambah Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);}
        .btn-vettix:hover { background-color: #00a8af; color: white; }
    </style>
</head>
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
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card form-card p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('rankings.index') }}" class="btn btn-light btn-sm me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Tambah Ranking Peserta</h4>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('rankings.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Event <span class="text-danger">*</span></label>
                                <select name="event_id" id="event_id" class="form-select" required>
                                    <option value="">-- Pilih Event --</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" data-event-name="{{ $event->nama_event }}">
                                            {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold mb-0">Peserta <span class="text-danger">*</span></label>
                                </div>
                                <select name="participant_id" id="participant_id" class="form-select" required>
                                    <option value="">-- Pilih Event Dulu --</option>
                                    @foreach($participants as $participant)
                                        <option value="{{ $participant->id }}" data-event-id="{{ $participant->event_id }}">
                                            {{ $participant->nama_peserta }} ({{ $participant->nim }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" id="participant-hint">
                                    <i class="fas fa-info-circle"></i> Pilih event terlebih dahulu
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Peringkat <span class="text-danger">*</span></label>
                                <input type="number" name="rank" class="form-control" min="1" placeholder="Contoh: 1" required>
                                <small class="text-muted">1 = Juara 1, 2 = Juara 2, dst</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Score/Nilai <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="score" class="form-control" min="0" placeholder="Contoh: 95.5" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Pencapaian</label>
                                <input type="text" name="achievement" class="form-control" placeholder="Contoh: Juara 1">
                                <small class="text-muted">Opsional</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('rankings.index') }}" class="btn btn-light w-50">Batal</a>
                            <button type="submit" class="btn btn-vettix w-50">
                                <i class="fa-solid fa-trophy"></i> Simpan Ranking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventSelect = document.getElementById('event_id');
            const participantSelect = document.getElementById('participant_id');
            const participantHint = document.getElementById('participant-hint');
            const allParticipants = Array.from(participantSelect.options).slice(1);

            eventSelect.addEventListener('change', function() {
                const selectedEventId = this.value;

                participantSelect.innerHTML = '<option value="">-- Pilih Peserta --</option>';

                if (!selectedEventId) {
                    participantHint.innerHTML = '<i class="fas fa-info-circle"></i> Pilih event terlebih dahulu';
                    return;
                }

                const filteredParticipants = allParticipants.filter(option => {
                    return option.getAttribute('data-event-id') === selectedEventId;
                });

                if (filteredParticipants.length > 0) {
                    filteredParticipants.forEach(option => {
                        participantSelect.appendChild(option.cloneNode(true));
                    });
                    participantHint.innerHTML = `<i class="fas fa-check-circle text-success"></i> Ditemukan ${filteredParticipants.length} peserta`;
                } else {
                    const eventName = this.options[this.selectedIndex].getAttribute('data-event-name');
                    participantHint.innerHTML = `<i class="fas fa-exclamation-triangle text-warning"></i> Belum ada peserta untuk event "${eventName}"`;
                }
            });
        });
    </script>
</body>
@endsection
</html>
