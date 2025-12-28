@extends('layouts.app')
<head><title>Vettix - Tambah Pembicara</title></head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Pembicara</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Cari pembicara</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection

@section('content')
<div class="flex min-h-screen">

    <main class="flex-1 p-12 bg-[#F8FAFC]">

        @if ($errors->any())
            <div class="max-w-6xl mx-auto mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500 mt-1"></i>
                    <div>
                        <p class="font-bold mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm p-12 max-w-6xl mx-auto">
            <div class="mb-10">
                <label class="block text-sm font-bold text-[#1E293B] mb-3">Pilih Platform <span class="text-red-500">*</span></label>
                <div class="flex gap-4 mb-6">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="platform" value="github" id="platform-github" class="hidden peer" checked>
                        <div class="border-2 border-gray-200 rounded-2xl p-4 text-center transition-all peer-checked:border-[#00BDD6] peer-checked:bg-[#00BDD6]/5">
                            <i class="fab fa-github text-3xl text-gray-700 mb-2"></i>
                            <p class="font-bold text-sm text-gray-700">GitHub</p>
                            <p class="text-xs text-gray-500">Developer Profile</p>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="platform" value="devto" id="platform-devto" class="hidden peer">
                        <div class="border-2 border-gray-200 rounded-2xl p-4 text-center transition-all peer-checked:border-[#00BDD6] peer-checked:bg-[#00BDD6]/5">
                            <i class="fab fa-dev text-3xl text-gray-700 mb-2"></i>
                            <p class="font-bold text-sm text-gray-700">Dev.to</p>
                            <p class="text-xs text-gray-500">Tech Writer</p>
                        </div>
                    </label>
                </div>

                <label class="block text-sm font-bold text-[#1E293B] mb-3" id="username-label">Masukkan Username GitHub <span class="text-red-500">*</span></label>
                <div class="flex space-x-4">
                    <div class="relative flex-1">
                        <input type="text" id="username"
                            class="w-full pl-6 pr-12 py-4 border border-[#E2E8F0] rounded-2xl outline-none focus:ring-2 focus:ring-[#00BDD6] transition-all text-[#64748B]"
                            placeholder="Contoh: torvalds, gaearon, atau username GitHub lainnya">
                        <i class="fas fa-search absolute right-6 top-5 text-[#CBD5E1]"></i>
                    </div>
                    <button type="button" onclick="ambilData()"
                        class="bg-[#4F8AFF] hover:bg-blue-600 text-white px-8 py-4 rounded-2xl flex items-center font-bold text-sm transition shadow-lg shadow-blue-100">
                        <i class="fas fa-download mr-2"></i> Ambil Data
                    </button>
                </div>
                <small class="text-xs text-gray-500 mt-2 block" id="platform-hint">
                    <i class="fab fa-github mr-1"></i> Sistem akan mengambil data otomatis dari profil GitHub publik
                </small>
            </div>

            <form action="{{ route('speakers.store') }}" method="POST">
                @csrf
                <div class="flex items-center space-x-4 mb-8">
                    <div class="bg-[#00BDD6] p-3 rounded-full text-white w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user-check text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1E293B] text-lg">Profil Pembicara</h3>
                        <p class="text-xs text-[#94A3B8]">Otomatis Mengambil Informasi</p>
                    </div>
                </div>

                <div class="border border-[#E2E8F0] rounded-[32px] p-10 flex items-center space-x-10 mb-8">
                    <div class="relative">
                        <img id="display_avatar" src="https://ui-avatars.com/api/?name=User"
                            class="w-32 h-32 rounded-full border-[6px] border-[#00BDD6]/5 object-cover">
                    </div>
                    <div class="flex-1 space-y-3">
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                            class="text-2xl font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-full mb-2" placeholder="Dr. Sarah Johnson">

                        <div class="space-y-1 text-[13px]">
                            <p class="text-[#64748B]">Institusi/Perusahaan : <input type="text" name="instansi" id="instansi" class="font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-auto ml-1" placeholder="Technology University"></p>
                            <p class="text-[#64748B]">Bidang Keahlian : <input type="text" name="role_job" id="role_job" class="font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-auto ml-1" placeholder="AI, Machine Learning"></p>
                            <p class="text-[#64748B]">Alamat Email : <input type="text" name="username_platform" id="username_platform" class="font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-auto ml-1" placeholder="dr.sarah@techuni.edu"></p>
                        </div>
                    </div>
                </div>

                <div class="border border-[#E2E8F0] rounded-[32px] p-10 mb-8">
                    <h4 class="font-bold text-[#1E293B] mb-4">Deskripsi Bio</h4>
                    <textarea name="bio_singkat" id="bio_singkat" rows="6"
                        class="w-full border-none p-0 focus:ring-0 text-[#64748B] text-sm leading-relaxed"
                        placeholder="Deskripsi bio pembicara akan tampil di sini..."></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-[#1E293B] mb-3">Pilih Event <span class="text-red-500">*</span></label>
                    <select name="event_id" required class="w-full pl-6 pr-12 py-4 border border-[#E2E8F0] rounded-2xl outline-none focus:ring-2 focus:ring-[#00BDD6] transition-all text-[#64748B]">
                        <option value="">-- Pilih Event --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">
                                {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-[#F0FDF4] border border-[#DCFCE7] text-[#166534] p-5 rounded-[24px] flex items-center mb-10" id="success-alert" style="display: none;">
                    <div class="bg-[#22C55E] p-2 rounded-full text-white mr-4">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm" id="success-message">Data Profil Berhasil Diambil</p>
                        <p class="text-[11px] text-[#22C55E] font-medium mt-0.5" id="last-updated">Last updated: just now</p>
                    </div>
                </div>

                <div class="flex justify-between items-center border-t border-gray-100 pt-8">
                    <p class="text-[12px] text-[#94A3B8] flex items-center">
                        <i class="fas fa-info-circle mr-2 text-sm"></i> Profile information is ready to be saved to the database.
                    </p>
                    <button type="submit" class="bg-[#00B087] hover:bg-[#009673] text-white px-10 py-4 rounded-full font-bold flex items-center shadow-lg shadow-green-100 transition transform active:scale-95">
                        <i class="fas fa-save mr-2"></i> Save to Database
                    </button>
                </div>

                <input type="hidden" name="avatar_url" id="avatar_url">
            </form>
        </div>
    </main>
</div>

<script>
document.querySelectorAll('input[name="platform"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const platform = this.value;
        const label = document.getElementById('username-label');
        const hint = document.getElementById('platform-hint');
        const input = document.getElementById('username');

        if (platform === 'github') {
            label.innerHTML = 'Masukkan Username GitHub <span class="text-red-500">*</span>';
            input.placeholder = 'Contoh: torvalds, gaearon, atau username GitHub lainnya';
            hint.innerHTML = '<i class="fab fa-github mr-1"></i> Sistem akan mengambil data otomatis dari profil GitHub publik';
        } else if (platform === 'devto') {
            label.innerHTML = 'Masukkan Username Dev.to <span class="text-red-500">*</span>';
            input.placeholder = 'Contoh: ben, jess, atau username Dev.to lainnya';
            hint.innerHTML = '<i class="fab fa-dev mr-1"></i> Sistem akan mengambil data otomatis dari profil Dev.to publik';
        }
    });
});

function ambilData() {
    const username = document.getElementById('username').value.trim();
    const platform = document.querySelector('input[name="platform"]:checked').value;

    if (!username) {
        alert('Masukkan username terlebih dahulu!');
        return;
    }

    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengambil Data...';
    btn.disabled = true;

    const apiEndpoint = platform === 'github' ? `/github/${username}` : `/devto/${username}`;


    fetch(apiEndpoint)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(`User ${platform === 'github' ? 'GitHub' : 'Dev.to'} tidak ditemukan!`);
                return;
            }

            document.getElementById('username_platform').value = data.username_platform || username;
            document.getElementById('nama_lengkap').value = data.nama_lengkap || '';
            document.getElementById('instansi').value = data.instansi || '';
            document.getElementById('role_job').value = data.role_job || '';
            document.getElementById('bio_singkat').value = data.bio_singkat || '';
            document.getElementById('avatar_url').value = data.avatar_url || '';

            if (data.avatar_url) {
                document.getElementById('display_avatar').src = data.avatar_url;
            }

            const successAlert = document.getElementById('success-alert');
            const successMessage = document.getElementById('success-message');
            successAlert.style.display = 'flex';
            successMessage.textContent = `Data Profil Berhasil Diambil dari ${platform === 'github' ? 'GitHub' : 'Dev.to'}`;

            const now = new Date();
            document.getElementById('last-updated').textContent = `Last updated: ${now.toLocaleTimeString('id-ID')}`;

            successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data. Coba lagi.');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
}
</script>
@endsection
