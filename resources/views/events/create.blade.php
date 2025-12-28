@extends('layouts.app')

<head><title>Vettix - Tambah Event</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Tambahkan Event Baru</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Manajemen event</h4>
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

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('events.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Event</label>
                    <input type="text" name="nama_event" class="form-control" placeholder="Masukkan nama event" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <div class="input-group">
                        <select name="category_id" class="form-select">
                            <option selected disabled>Pilih Kategori...</option>
                             @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                             @endforeach
                        </select>
                        <span class="input-group-text bg-white"><i class="fa-solid fa-chevron-down"></i></span>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tanggal Event</label>

                        <div class="d-flex align-items-center">

                            <div style="width: 40%; min-width: 250px;">
                                <input type="date"
                                       name="tanggal_event"
                                       class="form-control @error('tanggal_event') is-invalid @enderror"
                                       value="{{ old('tanggal_event') }}">
                            </div>

                            @error('tanggal_event')
                                <div class="ms-3 rounded-3 d-flex align-items-center p-2 fade show"
                                     style="background-color: #ffe6e6; border: 1px solid #ffcccc; color: #dc2626; max-width: 600px;">

                                    <div class="px-2">
                                        <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                                    </div>

                                    <div class="ps-1">
                                        <div class="fw-bold" style="font-size: 0.9rem;">Warning</div>
                                        <div style="font-size: 0.8rem; line-height: 1.2;">
                                            {{ $message }}
                                        </div>
                                    </div>

                                </div>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Deskripsi Event</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi event..."></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Waktu Event</label>
                        <div class="input-group">
                            <input type="text" name="waktu" class="form-control" placeholder="--:--">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-clock"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Durasi (jam)</label>
                        <input type="number" name="durasi" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Lokasi (Venue Kampus)</label>
                    <div class="input-group">
                        <select name="venue_id" class="form-select">
                            <option selected disabled>Pilih Ruangan...</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}">{{ $venue->nama_venue }} - Kapasitas: {{ $venue->kapasitas }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text bg-white"><i class="fa-solid fa-building"></i></span>
                    </div>
                    <div class="form-text text-muted">Data ruangan diambil dari database Anggota 1</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary px-4 fw-bold">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #2563eb; border: none;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection
