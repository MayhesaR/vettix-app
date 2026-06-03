@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Edit Sertifikat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-vettix { background-color: #00c2cb; color: white; border: none; }
        .btn-vettix:hover { background-color: #00a8af; color: white; }
    </style>
</head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Sertifikat</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Edit sertifikat</h4>
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
            <div class="col-md-6">
                <div class="card form-card p-4">
                    <h4 class="fw-bold mb-4 text-center">Edit Sertifikat</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/certificates/'.$certificate->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">No Sertifikat</label>
                            <input type="text" class="form-control" value="{{ $certificate->no_sertifikat }}" readonly disabled>
                            <small class="text-muted">Nomor sertifikat tidak dapat diubah</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Event <span class="text-danger">*</span></label>
                            <select name="event_id" id="event_id" class="form-select" required>
                                <option value="">-- Pilih Event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" data-event-name="{{ $event->nama_event }}"
                                        {{ $certificate->event_id == $event->id ? 'selected' : '' }}>
                                        {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Peserta <span class="text-danger">*</span></label>
                                <a href="{{ route('participants.create') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus"></i> Tambah Peserta Baru
                                </a>
                            </div>
                            <select name="participant_id" id="participant_id" class="form-select" required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach($participants as $participant)
                                    <option value="{{ $participant->id }}" data-event-id="{{ $participant->event_id }}"
                                        {{ $certificate->participant_id == $participant->id ? 'selected' : '' }}>
                                        {{ $participant->nama_peserta }} ({{ $participant->nim }}) - {{ $participant->asal_instansi }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" id="participant-hint">
                                <i class="fas fa-info-circle"></i> Ganti event untuk memfilter peserta yang sesuai
                            </small>
                        </div>



                        <div class="d-flex gap-2">
                            <a href="{{ url('/certificates') }}" class="btn btn-light w-50">Batal</a>
                            <button type="submit" class="btn btn-vettix w-50">Update Sertifikat</button>
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
            const currentParticipantId = {{ $certificate->participant_id }};

            eventSelect.addEventListener('change', function() {
                const selectedEventId = this.value;
                const currentSelectedParticipant = participantSelect.value;

                participantSelect.innerHTML = '<option value="">-- Pilih Peserta --</option>';

                if (!selectedEventId) {
                    participantHint.innerHTML = '<i class="fas fa-info-circle"></i> Pilih event terlebih dahulu untuk memfilter peserta';
                    return;
                }

                const filteredParticipants = allParticipants.filter(option => {
                    return option.getAttribute('data-event-id') === selectedEventId;
                });

                if (filteredParticipants.length > 0) {
                    filteredParticipants.forEach(option => {
                        const clonedOption = option.cloneNode(true);
                        participantSelect.appendChild(clonedOption);
                    });

                    if (currentSelectedParticipant) {
                        participantSelect.value = currentSelectedParticipant;
                    }

                    participantHint.innerHTML = `<i class="fas fa-check-circle text-success"></i> Ditemukan ${filteredParticipants.length} peserta untuk event ini`;
                } else {
                    const eventName = this.options[this.selectedIndex].getAttribute('data-event-name');
                    participantHint.innerHTML = `<i class="fas fa-exclamation-triangle text-warning"></i> Belum ada peserta terdaftar untuk event "${eventName}". <a href="{{ route('participants.create') }}" target="_blank">Tambah peserta baru</a>`;
                }
            });
        });
    </script>
</body>
@endsection
</html>
