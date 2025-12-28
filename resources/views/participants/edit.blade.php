@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Edit Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-vettix:hover { background-color: #00a8af; color: white; }
    </style>
</head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Participant</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Edit data peserta</h4>
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
                        <a href="{{ url('/participants') }}" class="btn btn-light me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Edit Data Peserta</h4>
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

                    <form action="{{ url('/participants/'.$participant->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Peserta <span class="text-danger">*</span></label>
                                <input type="text" name="nama_peserta" class="form-control"
                                    value="{{ old('nama_peserta', $participant->nama_peserta) }}"
                                    placeholder="Nama Lengkap Peserta" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="nim" class="form-control"
                                    value="{{ old('nim', $participant->nim) }}"
                                    placeholder="Nomor Induk Mahasiswa" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $participant->email) }}"
                                    placeholder="email@example.com" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Asal Instansi <span class="text-danger">*</span></label>
                                <input type="text" name="asal_instansi" class="form-control"
                                    value="{{ old('asal_instansi', $participant->asal_instansi) }}"
                                    placeholder="Nama Universitas/Institusi" required>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Dapat menggunakan auto-complete API Kampus
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Event <span class="text-danger">*</span></label>
                                <select name="event_id" class="form-select" required>
                                    <option value="">-- Pilih Event --</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}"
                                            {{ old('event_id', $participant->event_id) == $event->id ? 'selected' : '' }}>
                                            {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Kehadiran <span class="text-danger">*</span></label>
                                <select name="status_kehadiran" class="form-select" required>
                                    <option value="tidak_hadir"
                                        {{ old('status_kehadiran', $participant->status_kehadiran) == 'tidak_hadir' ? 'selected' : '' }}>
                                        Tidak Hadir
                                    </option>
                                    <option value="hadir"
                                        {{ old('status_kehadiran', $participant->status_kehadiran) == 'hadir' ? 'selected' : '' }}>
                                        Hadir
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                <strong>Info:</strong> Pastikan semua data sudah benar sebelum menyimpan perubahan.
                            </small>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ url('/participants') }}" class="btn btn-light w-50">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-vettix w-50">
                                <i class="fas fa-save"></i> Update Peserta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
</html>
