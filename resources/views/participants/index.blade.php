@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vettix - Participants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafb; margin: 0; font-family: sans-serif; }
        .main { margin-left: 10px; padding: 20px; }
        .v-header { background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #eee; margin-bottom: 20px; }
        .v-card { background: #fff; border-radius: 15px; border: 1px solid #eee; padding: 20px; }
        .active-menu { background: #00c2cb; color: #fff !important; border-radius: 8px; }
        .nav-link { color: #555; padding: 10px; display: block; text-decoration: none; margin-bottom: 5px; }
        .btn-vettix:hover { background-color: #00a8af; color: white; }
    </style>
</head>

@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Manage Participant</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Manajemen peserta di sini</h4>
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
    <div class="v-header">
        <h2>Participants</h2>
        <p class="text-muted">Kelola data peserta event di sini.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="v-card">
        <div class="d-flex justify-content-between mb-3">
            <span class="fw-bold">Total Peserta: {{ count($participants) }}</span>
            <a href="{{ url('participants/create') }}" class="btn btn-vettix btn-sm">
                <i class="fas fa-plus"></i> Tambah Peserta
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>Asal Instansi</th>
                        <th>Event</th>
                        <th>Status Kehadiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->nama_peserta }}</td>
                        <td>{{ $p->nim }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->asal_instansi }}</td>
                        <td>{{ $p->event->nama_event ?? '-' }}</td>
                        <td>
                            @if($p->status_kehadiran == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @else
                                <span class="badge bg-secondary">Tidak Hadir</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('participants/'.$p->id.'/edit') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ url('participants/'.$p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus peserta ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data peserta</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
</html>
