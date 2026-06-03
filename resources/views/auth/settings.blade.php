@extends('layouts.app')

@section('title-text', 'Pengaturan Akun')

@section('page-title')
<div class="d-flex align-items-center">
    <div>
        <h4 class="fw-bold text-dark mb-0">Pengaturan Akun</h4>
        <div class="text-muted small">Kelola informasi profil dan keamanan akun Anda</div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Success Message Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 p-3" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5" style="color: #059669;"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <!-- Profile Info Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-bold py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-user text-muted"></i>
                        <span>Informasi Profil</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="form-control @error('name') is-invalid @enderror" 
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="form-control @error('email') is-invalid @enderror" 
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-brand">
                            <i class="fa-regular fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security / Password Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-bold py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-muted"></i>
                        <span>Ubah Password</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        
                        <!-- Keep profile fields intact during password updates so validation doesn't fail -->
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="Min. 8 karakter"
                                class="form-control @error('password') is-invalid @enderror" 
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                placeholder="Ulangi password baru"
                                class="form-control" 
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-brand">
                            <i class="fa-solid fa-key"></i>
                            <span>Perbarui Password</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
