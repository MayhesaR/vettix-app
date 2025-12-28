@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vettix - Sertifikat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafb; margin: 0; font-family: sans-serif; }
        .main { margin-left: 50px; padding: 20px; }
        .v-header { background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #eee; margin-bottom: 20px; }
        .v-card { background: #fff; border-radius: 15px; border: 1px solid #eee; padding: 20px; height: 100%; }
        .active-menu { background: #00c2cb; color: #fff !important; border-radius: 8px; }
        .nav-link { color: #555; padding: 10px; display: block; text-decoration: none; margin-bottom: 5px; }
        /* Preview Sertifikat Biru */
        .cert-box { background: #f0f7ff; border: 1px solid #d0e4ff; border-radius: 12px; padding: 20px; text-align: center; }
        .blue-text { color: #1e3a8a; font-weight: bold; }
    </style>
</head>

@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Sertifikat</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Kelola sertifikat peserta di sini.</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

@section('content')
<body>

<div class="main">
    <div class="row">
        <div class="col-md-8">
            <div class="v-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fw-bold">Peserta ({{ count($certificates) }})</span>
                        <select id="participantFilter" class="form-select form-select-sm" style="width: 250px;">
                            <option value="">🔍 Pilih Peserta</option>
                            @foreach($certificates->unique('participant_id')->sortBy('participant.nama_peserta') as $cert)
                                @if($cert->participant)
                                    <option value="{{ $cert->participant_id }}" data-cert-id="{{ $cert->id }}">
                                        {{ $cert->participant->nama_peserta }} - {{ $cert->participant->nim }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ url('certificates/create') }}" class="btn btn-primary btn-sm">+ Generate</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No Sertifikat</th>
                            <th>Nama Peserta</th>
                            <th>Event</th>
                            <th>Status Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certificates as $c)
                        <tr class="certificate-row" data-participant-id="{{ $c->participant_id }}" data-cert-id="{{ $c->id }}">
                            <td>{{ $c->no_sertifikat }}</td>
                            <td>{{ $c->participant->nama_peserta ?? '-' }}</td>
                            <td>{{ $c->event->nama_event ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $c->participant->status_kehadiran == 'hadir' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($c->participant->status_kehadiran ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ url('certificates/'.$c->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ url('certificates/'.$c->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada sertifikat</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <div class="v-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p class="fw-bold small mb-0">Certificate Preview</p>
                    <span id="cert-number" class="badge bg-secondary" style="font-size: 9px;">
                        @if($certificates->isNotEmpty())
                            {{ $certificates->first()->no_sertifikat }}
                        @else
                            SR-XXX/2025
                        @endif
                    </span>
                </div>
                <div class="cert-box" id="certificatePreview">
                    <div class="small blue-text">CERTIFICATE OF COMPLETION</div>
                    <p class="mt-3 mb-0" style="font-size: 10px;">This is to certify that</p>
                    <h4 class="blue-text" id="preview-name">
                        @if($certificates->isNotEmpty())
                            {{ $certificates->first()->participant->nama_peserta ?? 'Peserta' }}
                        @else
                            Nama Peserta
                        @endif
                    </h4>
                    <p style="font-size: 10px;">has successfully completed</p>
                    <div class="text-primary fw-bold" id="preview-event">
                        @if($certificates->isNotEmpty())
                            {{ $certificates->first()->event->nama_event ?? 'Event Name' }}
                        @else
                            Nama Event
                        @endif
                    </div>
                    <div class="mt-4 d-flex justify-content-between">
                        <small style="font-size: 8px;">Instructor Signature</small>
                        <div id="preview-qr" style="width: 40px; height: 40px; border: 1px solid #ccc; background: #fff;">
                            @if($certificates->isNotEmpty() && $certificates->first()->qr_code_url)
                                <img src="{{ $certificates->first()->qr_code_url }}" alt="QR" style="width: 100%; height: 100%;">
                            @else
                                QR
                            @endif
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100 mt-3">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const participantFilter = document.getElementById('participantFilter');
    const certificateRows = document.querySelectorAll('.certificate-row');

    const certificatesData = [
        @foreach($certificates as $c)
        {
            id: {{ $c->id }},
            participant_id: {{ $c->participant_id }},
            no_sertifikat: '{{ $c->no_sertifikat }}',
            nama_peserta: '{{ $c->participant->nama_peserta ?? 'N/A' }}',
            nama_event: '{{ $c->event->nama_event ?? 'N/A' }}',
            qr_code_url: '{{ $c->qr_code_url ?? '' }}'
        },
        @endforeach
    ];

    participantFilter.addEventListener('change', function() {
        const selectedParticipantId = this.value;

        certificateRows.forEach(row => {
            if (!selectedParticipantId || row.dataset.participantId === selectedParticipantId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        if (selectedParticipantId) {
            const cert = certificatesData.find(c => c.participant_id == selectedParticipantId);
            if (cert) {
                document.getElementById('cert-number').textContent = cert.no_sertifikat;
                document.getElementById('preview-name').textContent = cert.nama_peserta;
                document.getElementById('preview-event').textContent = cert.nama_event;

                const qrContainer = document.getElementById('preview-qr');
                if (cert.qr_code_url) {
                    qrContainer.innerHTML = `<img src="${cert.qr_code_url}" alt="QR" style="width: 100%; height: 100%;">`;
                } else {
                    qrContainer.innerHTML = 'QR';
                }

                const previewBox = document.getElementById('certificatePreview');
                previewBox.style.transform = 'scale(1.02)';
                previewBox.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    previewBox.style.transform = 'scale(1)';
                }, 300);
            }
        }
    });

    certificateRows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function() {
            const participantId = this.dataset.participantId;
            participantFilter.value = participantId;
            participantFilter.dispatchEvent(new Event('change'));

            certificateRows.forEach(r => r.classList.remove('table-active'));
            this.classList.add('table-active');
        });
    });
});
</script>

</body>
@endsection
</html>
