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
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <strong>Gagal!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('events.update', $event->id) }}" method="POST">
                 @csrf
                 @method('PUT') 

                 <!-- Nama Event -->
                 <div class="mb-3">
                     <label class="form-label fw-bold small">Nama Event</label>
                     <input type="text" name="nama_event"
                            class="form-control @error('nama_event') is-invalid @enderror"
                            value="{{ old('nama_event', $event->nama_event) }}"
                            placeholder="Contoh: Seminar XYZ">
                     <div class="form-text text-muted small">Nama lengkap dari event kampus yang akan diselenggarakan. Contoh: Seminar Nasional AI.</div>
                     @error('nama_event')
                         <div class="text-danger small mt-1">
                             <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                         </div>
                     @enderror
                 </div>

                 <!-- Lokasi / Venue -->
                 <div class="mb-3">
                     <label class="form-label fw-bold small">Lokasi</label>
                     <select name="venue_id" class="form-select @error('venue_id') is-invalid @enderror">
                         <option value="" disabled>Pilih Ruangan...</option>
                         @foreach($venues as $venue)
                             <option value="{{ $venue->id }}"
                                 {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                 {{ $venue->nama_venue }}
                             </option>
                         @endforeach
                     </select>
                     <div class="form-text text-muted small">Pilih ruangan atau lokasi kampus tempat pelaksanaan event. Data ruangan diambil dari database Anggota 1.</div>
                     @error('venue_id')
                         <div class="text-danger small mt-1">
                             <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                         </div>
                     @enderror
                 </div>

                 <!-- Tanggal & Kategori -->
                 <div class="row mb-3">
                     <div class="col-md-6">
                         <label class="form-label fw-bold small">Tanggal Event</label>
                         <div class="input-group">
                             <input type="date" name="tanggal_event"
                                    class="form-control @error('tanggal_event') is-invalid @enderror"
                                    value="{{ old('tanggal_event', $event->tanggal_event) }}">
                             <span class="input-group-text bg-white"><i class="fa-regular fa-calendar"></i></span>
                         </div>
                         <div class="form-text text-muted small">Tanggal pelaksanaan event. Sistem akan mengecek apakah tanggal tersebut merupakan hari libur nasional.</div>
                         @error('tanggal_event')
                             <div class="text-danger small mt-1">
                                 <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                             </div>
                         @enderror
                     </div>

                     <div class="col-md-6">
                         <label class="form-label fw-bold small">Kategori</label>
                         <select name="category_id" id="category_select" class="form-select @error('category_id') is-invalid @enderror">
                             <option value="" disabled>Pilih Kategori...</option>
                             @foreach($categories as $category)
                                 <option value="{{ $category->id }}"
                                     {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                     {{ $category->nama_kategori }}
                                 </option>
                             @endforeach
                             <option value="new" {{ old('category_id') === 'new' ? 'selected' : '' }}>+ Tambah Kategori Baru...</option>
                         </select>
                         <div class="form-text text-muted small">Pilih kategori yang sesuai. Jika kategori tidak ada, silakan pilih "+ Tambah Kategori Baru...".</div>
                         @error('category_id')
                             <div class="text-danger small mt-1">
                                 <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                             </div>
                         @enderror
                     </div>
                 </div>

                 <!-- Input Kategori Baru (Dinamis) -->
                 <div class="mb-3 p-3 border rounded-3 bg-light" id="new_category_input_wrapper" style="display: none;">
                     <label class="form-label fw-bold small text-primary">Nama Kategori Baru</label>
                     <input type="text" name="new_category" id="new_category_input" class="form-control @error('new_category') is-invalid @enderror" placeholder="Masukkan kategori baru" value="{{ old('new_category') }}">
                     <div class="form-text text-muted small">Nama kategori baru yang akan disimpan permanen ke sistem.</div>
                     @error('new_category')
                         <div class="text-danger small mt-1">
                             <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                         </div>
                     @enderror
                 </div>

                 <!-- Waktu & Durasi -->
                 <div class="row mb-3">
                     <div class="col-md-8">
                         <label class="form-label fw-bold small">Waktu Event</label>
                         <div class="input-group">
                             <input type="text" name="waktu" class="form-control" placeholder="Contoh: 13:30 - 15:30 WIB"
                                    value="{{ old('waktu', $event->waktu) }}">
                             <span class="input-group-text bg-white"><i class="fa-regular fa-clock"></i></span>
                         </div>
                         <div class="form-text text-muted small">Format pengisian waktu bebas (Contoh: 13:30 - 15:30 WIB).</div>
                     </div>
                     <div class="col-md-4">
                         <label class="form-label fw-bold small">Durasi (jam)</label>
                         <input type="number" name="durasi" class="form-control" placeholder="Contoh: 2"
                                value="{{ old('durasi', $event->durasi) }}">
                         <div class="form-text text-muted small">Estimasi durasi acara dalam satuan jam (Contoh: 2).</div>
                     </div>
                 </div>

                 <!-- Deskripsi -->
                 <div class="mb-4">
                     <label class="form-label fw-bold small">Deskripsi Event</label>
                     <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                     <div class="form-text text-muted small">Deskripsi lengkap mengenai agenda, target peserta, maupun informasi penting lainnya terkait event.</div>
                     @error('deskripsi')
                         <div class="text-danger small mt-1">
                             <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                         </div>
                     @enderror
                 </div>

                 <div class="d-flex justify-content-end gap-2 border-top pt-3">
                     <a href="{{ route('events.index') }}" class="btn btn-outline-secondary px-4 fw-bold">Cancel</a>

                     <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #2563eb; border: none;">
                         <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
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
