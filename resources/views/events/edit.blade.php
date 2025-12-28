@extends('layouts.app')


<head><title>Vettix - Edit Event</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <a href="{{ route('events.index') }}" class="btn btn-light btn-sm rounded-circle me-3 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Event: {{ $event->nama_event }}</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Perbarui detail acara kampus</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

{{-- PANGGIL SIDEBAR KHUSUS EVENT --}}
@include('events.sidebar')

@section('content')
<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded p-1 me-2 text-primary" style="height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Detail Event</h6>
                    <small class="text-muted">Update Informasi event di sini</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4 pt-0">
            <form action="{{ route('events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Event</label>
                    <input type="text" name="nama_event"
                           class="form-control"
                           value="{{ old('nama_event', $event->nama_event) }}"
                           placeholder="Contoh: Seminar XYZ">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Lokasi</label>
                    <select name="venue_id" class="form-select">
                        <option disabled>Pilih Ruangan...</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}"
                                {{-- Jika ID venue sama dengan yang di database, tambahkan atribut SELECTED --}}
                                {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                {{ $venue->nama_venue }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Tanggal Event</label>
                        <div class="input-group">
                            <input type="date" name="tanggal_event"
                                   class="form-control"
                                   value="{{ old('tanggal_event', $event->tanggal_event) }}">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-calendar"></i></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option disabled>Pilih Kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{-- Cek Selected --}}
                                    {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Karena field ini belum ada di database migration sebelumnya, kita gunakan value dummy atau kosong dulu --}}
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Waktu Event</label>
                        <div class="input-group">
                            <input type="text" name="waktu" class="form-control" placeholder="13:30 - 15:30"
                                   value="{{ old('waktu', '13:30 - 15:30') }}">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-clock"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Durasi (jam)</label>
                        <input type="number" name="durasi" class="form-control" placeholder="2"
                               value="{{ old('durasi', '2') }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Deskripsi Event</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary px-4 fw-bold">Cancel</a>

                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #2563eb; border: none;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
