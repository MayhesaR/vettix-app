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

                <!-- Nama Event -->
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Event</label>
                    <input type="text" name="nama_event" class="form-control @error('nama_event') is-invalid @enderror" placeholder="Masukkan nama event" value="{{ old('nama_event') }}">
                    <div class="form-text text-muted small">Nama lengkap dari event kampus yang akan diselenggarakan. Contoh: Seminar Nasional AI.</div>
                    @error('nama_event')
                        <div class="text-danger small mt-1">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <div class="input-group">
                        <select name="category_id" id="category_select" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="" disabled {{ old('category_id') === null ? 'selected' : '' }}>Pilih Kategori...</option>
                             @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                             @endforeach
                            <option value="new" {{ old('category_id') === 'new' ? 'selected' : '' }}>+ Tambah Kategori Baru...</option>
                        </select>
                        <span class="input-group-text bg-white"><i class="fa-solid fa-chevron-down"></i></span>
                    </div>
                    <div class="form-text text-muted small">Pilih kategori yang sesuai. Jika kategori tidak ada, silakan pilih "+ Tambah Kategori Baru...".</div>
                    @error('category_id')
                        <div class="text-danger small mt-1">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                        </div>
                    @enderror

                    <!-- Input Kategori Baru (Dinamis) -->
                    <div class="mt-2 p-3 border rounded-3 bg-light" id="new_category_input_wrapper" style="display: none;">
                        <label class="form-label fw-bold small text-primary">Nama Kategori Baru</label>
                        <input type="text" name="new_category" id="new_category_input" class="form-control @error('new_category') is-invalid @enderror" placeholder="Masukkan kategori baru" value="{{ old('new_category') }}">
                        <div class="form-text text-muted small">Nama kategori baru yang akan disimpan permanen ke sistem.</div>
                        @error('new_category')
                            <div class="text-danger small mt-1">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Event -->
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
                        <div class="form-text text-muted small mt-1">Tanggal pelaksanaan event. Sistem akan mengecek apakah tanggal tersebut merupakan hari libur nasional.</div>
                    </div>
                </div>

                <!-- Deskripsi Event -->
                <div class="mb-3">
                    <label class="form-label fw-bold small">Deskripsi Event</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Masukkan deskripsi event...">{{ old('deskripsi') }}</textarea>
                    <div class="form-text text-muted small">Deskripsi lengkap mengenai agenda, target peserta, maupun informasi penting lainnya terkait event.</div>
                    @error('deskripsi')
                        <div class="text-danger small mt-1">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Waktu & Durasi (Opsional) -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Waktu Event</label>
                        <div class="input-group">
                            <input type="text" name="waktu" class="form-control" placeholder="--:--" value="{{ old('waktu') }}">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-clock"></i></span>
                        </div>
                        <div class="form-text text-muted small">Waktu mulai pelaksanaan event (Format bebas).</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Durasi (jam)</label>
                        <input type="number" name="durasi" class="form-control" placeholder="" value="{{ old('durasi') }}">
                        <div class="form-text text-muted small">Estimasi durasi dalam satuan jam.</div>
                    </div>
                </div>

                <!-- Lokasi / Venue -->
                <div class="mb-4">
                    <label class="form-label fw-bold small">Lokasi (Venue Kampus)</label>
                    <div class="input-group">
                        <select name="venue_id" class="form-select @error('venue_id') is-invalid @enderror">
                            <option value="" disabled {{ old('venue_id') === null ? 'selected' : '' }}>Pilih Ruangan...</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->nama_venue }} - Kapasitas: {{ $venue->kapasitas }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text bg-white"><i class="fa-solid fa-building"></i></span>
                    </div>
                    <div class="form-text text-muted small">Pilih ruangan atau lokasi kampus tempat pelaksanaan event. Data ruangan diambil dari database Anggota 1.</div>
                    @error('venue_id')
                        <div class="text-danger small mt-1">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary px-4 fw-bold">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #2563eb; border: none;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save
                    </button>
                </div>

            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const categorySelect = document.getElementById('category_select');
                    const newCategoryWrapper = document.getElementById('new_category_input_wrapper');
                    const newCategoryInput = document.getElementById('new_category_input');

                    function toggleNewCategory() {
                        if (categorySelect.value === 'new') {
                            newCategoryWrapper.style.display = 'block';
                            newCategoryInput.focus();
                        } else {
                            newCategoryWrapper.style.display = 'none';
                        }
                    }

                    categorySelect.addEventListener('change', toggleNewCategory);
                    toggleNewCategory(); // Jalankan sekali saat load page jika ada error validation
                });
            </script>
        </div>
    </div>
</div>


@endsection
