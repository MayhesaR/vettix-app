@extends('layouts.app')

@section('title-text', 'Edit Ruangan')

@section('page-title', 'Edit Ruangan')

@section('content')
<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-slate-800">Form Edit Ruangan</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('venues.update', $venue->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="nama_venue">Nama Ruangan</label>
                        <input type="text" name="nama_venue" id="nama_venue" class="form-control @error('nama_venue') is-invalid @enderror"
                               placeholder="Contoh: Auditorium Gd. K" value="{{ old('nama_venue', $venue->nama_venue) }}" required>
                        @error('nama_venue')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="gedung">Nama Gedung</label>
                        <input type="text" name="gedung" id="gedung" class="form-control @error('gedung') is-invalid @enderror"
                               placeholder="Contoh: Gedung Kuliah Bersama" value="{{ old('gedung', $venue->gedung) }}" required>
                        @error('gedung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="provinsi">Provinsi</label>
                        <select name="provinsi_id" id="provinsi" class="form-select @error('provinsi_id') is-invalid @enderror" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="kota">Kota / Kabupaten</label>
                        <select name="kota_id" id="kota" class="form-select @error('kota_id') is-invalid @enderror" required>
                            <option value="">Pilih Kota</option>
                        </select>
                        @error('kota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="kecamatan">Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatan" class="form-select @error('kecamatan_id') is-invalid @enderror" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        @error('kecamatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="kapasitas">Kapasitas (Orang)</label>
                        <input type="number" name="kapasitas" id="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                               placeholder="Contoh: 100" value="{{ old('kapasitas', $venue->kapasitas) }}" required>
                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="fasilitas">Fasilitas</label>
                        <input type="text" name="fasilitas" id="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror"
                               placeholder="Contoh: AC, WiFi, Sound System, Proyektor" value="{{ old('fasilitas', $venue->fasilitas) }}">
                        @error('fasilitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('venues.index') }}" class="btn btn-light px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-brand px-4 text-white">
                            <i class="fa-regular fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Wilayah API Script with Pre-selection -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const provinceSelect = document.getElementById('provinsi');
        const citySelect = document.getElementById('kota');
        const districtSelect = document.getElementById('kecamatan');

        // Saved values from the DB
        const savedProvinceId = "{{ $venue->provinsi_id }}";
        const savedCityId = "{{ $venue->kota_id }}";
        const savedDistrictId = "{{ $venue->kecamatan_id }}";

        // Helper: Populate select element
        function populateSelect(selectEl, data, placeholder, selectedId) {
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            data.forEach(item => {
                let option = document.createElement('option');
                option.value = item.id;
                option.text = item.name;
                if (selectedId && String(item.id) === String(selectedId)) {
                    option.selected = true;
                }
                selectEl.appendChild(option);
            });
        }

        // 1. Fetch Provinces & Load cascade
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(response => response.json())
            .then(provinces => {
                populateSelect(provinceSelect, provinces, 'Pilih Provinsi', savedProvinceId);
                
                // If a saved province exists, fetch saved cities
                if (savedProvinceId) {
                    return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${savedProvinceId}.json`);
                }
            })
            .then(response => response ? response.json() : null)
            .then(regencies => {
                if (regencies) {
                    populateSelect(citySelect, regencies, 'Pilih Kota', savedCityId);
                    
                    // If a saved city exists, fetch saved districts
                    if (savedCityId) {
                        return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${savedCityId}.json`);
                    }
                }
            })
            .then(response => response ? response.json() : null)
            .then(districts => {
                if (districts) {
                    populateSelect(districtSelect, districts, 'Pilih Kecamatan', savedDistrictId);
                }
            })
            .catch(error => console.error('Error during initial wilayah loading:', error));

        // 2. Change Event for Province selection
        provinceSelect.addEventListener('change', function () {
            const provinceId = this.value;
            citySelect.innerHTML = '<option value="">Pilih Kota</option>';
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            if (provinceId) {
                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                    .then(response => response.json())
                    .then(regencies => {
                        populateSelect(citySelect, regencies, 'Pilih Kota', null);
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        });

        // 3. Change Event for City selection
        citySelect.addEventListener('change', function () {
            const cityId = this.value;
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            if (cityId) {
                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`)
                    .then(response => response.json())
                    .then(districts => {
                        populateSelect(districtSelect, districts, 'Pilih Kecamatan', null);
                    })
                    .catch(error => console.error('Error fetching districts:', error));
            }
        });
    });
</script>
@endsection
