@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Pendaftaran Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-vettix { background-color: #00c2cb; color: white; border: none; transition: all 0.2s; }
        .btn-vettix:hover { background-color: #00a8af; color: white; }
    </style>
</head>

@section('title')
<div class="d-flex align-items-center mb-0">
    <div>
        <h4 class="fw-bold text-dark mb-0">Pendaftaran Event</h4>
        <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Registrasi Mandiri Peserta</h4>
    </div>
</div>
@endsection

@section('content')
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card form-card p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-light me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Daftar Event Baru</h4>
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

                    <form action="{{ route('participants.self-register', $event->id) }}" method="POST">
                        @csrf

                        <!-- Event Info -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Event yang Diikuti</label>
                            <input type="text" class="form-control bg-light" value="{{ $event->nama_event }}" readonly disabled>
                            @if($event->venue)
                                <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> {{ $event->venue->nama_venue }}</small>
                            @endif
                        </div>

                        <!-- Readonly User Info -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly disabled>
                            <small class="text-muted">Nama disesuaikan dengan akun Vettix Anda</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                            <small class="text-muted">Email disesuaikan dengan akun Vettix Anda</small>
                        </div>

                        <hr class="my-4 border-slate-200">

                        <!-- User Input Required Fields -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIM / Nomor Induk Mahasiswa <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim', $prefilledNim) }}" placeholder="Contoh: 1301210001" required>
                            <small class="text-muted">Masukkan NIM unik Anda</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Asal Instansi / Universitas <span class="text-danger">*</span></label>
                            <input type="text" name="asal_instansi" class="form-control" value="{{ old('asal_instansi', $prefilledInstansi) }}" placeholder="Contoh: Telkom University" required>
                            <small class="text-muted">Masukkan asal kampus atau institusi Anda</small>
                        </div>

                        <div class="alert alert-info py-2 px-3 mt-4">
                            <small class="d-flex align-items-center gap-2">
                                <i class="fas fa-info-circle text-info"></i>
                                <span>Setelah mendaftar, status kehadiran Anda akan ditandai sebagai <strong>Tidak Hadir</strong> sampai diverifikasi oleh panitia.</span>
                            </small>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-light w-50">Batal</a>
                            <button type="submit" class="btn btn-vettix w-50">Daftar Sekarang</button>
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
