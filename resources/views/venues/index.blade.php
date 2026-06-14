@extends('layouts.app')

{{-- ================= TITLE ================= --}}
<head><title>Vettix - Manajemen</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
    <div>
        <h4 class="fw-bold text-dark mb-0">Manajemen Inventaris Tempat</h4>
        <h4 class="text-muted small mb-0" style="font-size: 15px;">
            Kelola ruangan dan fasilitas anda
        </h4>
    </div>

    <div class="ms-auto d-flex gap-2">
        <button class="btn btn-light btn-sm">
            <i class="fa-regular fa-bell"></i>
        </button>
        <button class="btn btn-light btn-sm">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
</div>
@endsection


{{-- ================= CONTENT ================= --}}
@section('content')
<div class="container-fluid px-0">

    {{-- ===== ALERT SUCCESS ===== --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4"
             style="background-color:#d1fae5;color:#065f46;">
            <i class="fa-solid fa-circle-check me-2"></i>
            <strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ================= CARD TAMBAH RUANGAN ================= --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Tambah Ruangan</h5>

            <form action="{{ route('venues.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" name="nama_venue" class="form-control"
                               placeholder="Enter room name" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bangunan</label>
                        <input type="text" name="gedung" class="form-control"
                               placeholder="Enter building name" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <select name="provinsi_id" id="provinsi" class="form-select" required>
                            <option value="">Choose province</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kota</label>
                        <select name="kota_id" id="kota" class="form-select" required>
                            <option value="">Choose city</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Daerah (Kecamatan)</label>
                        <select name="kecamatan_id" id="kecamatan" class="form-select" required>
                            <option value="">Choose district</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control"
                               placeholder="Enter capacity" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fasilitas</label>
                        <input type="text" name="fasilitas" class="form-control"
                               placeholder="e.g. WiFi, Projector, AC">
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button type="reset" class="btn btn-light px-4">Cancel</button>
                        <button type="submit" class="btn px-4 text-white"
                                style="background-color: #00bfd8
                                ;">
                            Tambah Ruangan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= CARD INVENTORI ================= --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Inventori Ruangan</h5>

            <form action="{{ route('venues.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text"
                           name="search"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search rooms..."
                           value="{{ request('search') }}">
                </div>
                @if(request('search'))
                    <a href="{{ route('venues.index') }}" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" style="width: 31px; height: 31px;" title="Reset Filter">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Nama Ruangan</th>
                            <th>Bangunan</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Fasilitas</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($venues as $venue)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $venue->nama_venue }}</td>
                                <td>{{ $venue->gedung }}</td>
                                <td>{{ $venue->kapasitas }}</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">
                                        Tersedia
                                    </span>
                                </td>
                                <td>{{ $venue->fasilitas }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('venues.edit', $venue->id) }}"
                                       class="btn btn-link text-primary p-0 me-2">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <button class="btn btn-link text-danger p-0 btn-delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $venue->id }}"
                                            data-name="{{ $venue->nama_venue }}">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Tidak ada ruangan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white py-3 d-flex justify-content-between">
            <small class="text-muted">
                Showing {{ count($venues) }} rooms
            </small>

            <a href="{{ route('venues.export.pdf', ['search' => request('search')]) }}" class="btn btn-sm text-success fw-bold text-decoration-none">
                <i class="fa-solid fa-file-arrow-down me-2"></i>
                Cetak PDF
            </a>
        </div>
    </div>
</div>

{{-- ================= MODAL DELETE ================= --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3 text-center">
            <h5 class="fw-bold">Hapus Ruangan?</h5>

            <p class="text-muted small mb-3">
                Apakah yakin ingin menghapus
                <strong id="modal-name"></strong>?
            </p>

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-light px-4" data-bs-dismiss="modal">
                    Cancel
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger px-4">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
    // --- SCRIPT MODAL DELETE ---
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('modal-name').innerText = this.dataset.name;
            document.getElementById('deleteForm').action = `/venues/${this.dataset.id}`;
        });
    });
    // --- SCRIPT API WILAYAH (EMSIFA) ---
    const provinceSelect = document.getElementById('provinsi');
    const citySelect = document.getElementById('kota');
    const districtSelect = document.getElementById('kecamatan');
    // 1. Load Data Provinsi
    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
        .then(response => response.json())
        .then(provinces => {
            provinces.forEach(province => {
                let option = document.createElement('option');
                option.value = province.id;
                option.text = province.name;
                provinceSelect.appendChild(option);
            });
        });
    // 2. Load Data Kota ketika Provinsi dipilih
    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        citySelect.innerHTML = '<option value="">Choose city</option>';
        districtSelect.innerHTML = '<option value="">Choose district</option>';
        if (provinceId) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                .then(response => response.json())
                .then(regencies => {
                    regencies.forEach(regency => {
                        let option = document.createElement('option');
                        option.value = regency.id;
                        option.text = regency.name;
                        citySelect.appendChild(option);
                    });
                });
        }
    });
    // 3. Load Data Kecamatan ketika Kota dipilih
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        districtSelect.innerHTML = '<option value="">Choose district</option>';
        if (cityId) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`)
                .then(response => response.json())
                .then(districts => {
                    districts.forEach(district => {
                        let option = document.createElement('option');
                        option.value = district.id;
                        option.text = district.name;
                        districtSelect.appendChild(option);
                    });
                });
        }
    });
</script>
@endsection
