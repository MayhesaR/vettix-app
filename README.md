# Vettix - Event Management Platform

**Vettix** adalah aplikasi manajemen event berbasis **Laravel 12** yang dirancang untuk mengelola pendaftaran peserta, venue, pembicara, penilaian/ranking, ulasan event, hingga penerbitan sertifikat digital berbasis QR code dan ekspor laporan PDF.

---

## 🚀 Fitur Utama

### 🏢 1. Manajemen Event & Venue
- **Event Management**: Buat, perbarui, dan kelola event beserta kategori, tanggal, lokasi venue, serta kuota.
- **Venue Management**: Pendaftaran venue beserta kapasitas, lokasi (provinsi/kota/kecamatan), dan fasilitas.
- **Ekspor PDF**: Cetak dan unduh ringkasan data Event dan Venue dalam format PDF (`barryvdh/laravel-dompdf`).
- **RESTful API**: Endpoint API untuk integrasi data Events dan Venues (`/api/events`, `/api/venues`).

### 👥 2. Peserta & Mandiri (Self-Register)
- **Pendaftaran Mandiri**: Peserta dapat mendaftar langsung ke event yang tersedia melalui form self-register.
- **Pencatatan Kehadiran**: Pelacakan status kehadiran peserta (Hadir / Belum Hadir).
- **Dashboard Multi-Role**:
  - **Admin**: Akses statistik lengkap, kelola event, ulasan, ranking, dan penerbitan sertifikat.
  - **Peserta**: Melihat daftar event yang diikuti, status pendaftaran, serta mengunduh sertifikat milik sendiri.

### 📜 3. Sertifikat Digital & QR Code
- **Penerbitan Sertifikat**: Pembuatan nomor sertifikat unik untuk peserta yang terdaftar pada event tertentu.
- **QR Code Verification**: Generasi kode QR otomatis untuk verifikasi keaslian sertifikat.
- **Cetak/Unduh PDF**: Template Blade PDF siap cetak untuk sertifikat peserta.

### 🎙️ 4. Pembicara (Speakers) & Integrasi Platform
- **Manajemen Pembicara**: Menyimpan profil pembicara (nama, job role, instansi, bio singkat).
- **Integrasi Platform Developer**: Fitur fetching profil dari **GitHub API** dan **Dev.to API** berdasarkan username.

### 🏆 5. Ranking & Penilaian Event
- **Pencatatan Prestasi**: Input skor, peringkat (rank), serta piala/achievement peserta per event.
- **Ringkasan Ranking**: Tampilan snapshot top ranking di Dashboard Admin.

### ⭐ 6. Review & Modrasi Ulasan
- **Ulasan Peserta**: Penilaian rating (star) dan ulasan pengalaman event.
- **Moderas Admin**: Toggle status publikasi ulasan (`is_published`) sebelum ditampilkan ke publik/dashboard.

---

## 🛠️ Tech Stack & Dependensi

- **Backend Framework**: [Laravel 12](https://laravel.com/) (PHP ^8.2)
- **Frontend / UI**:
  - Blade Templating Engine
  - Bootstrap 5 & Tailwind CSS v4 (Vite integration)
  - FontAwesome 6 (Icons)
  - Custom Responsive Dashboard Layout
- **Database**: PostgreSQL / MySQL / SQLite
- **PDF Generation**: `barryvdh/laravel-dompdf`
- **Build Tool**: Vite (`vite`, `@tailwindcss/vite`, `laravel-vite-plugin`)
- **Process Runner**: Concurrently (`php artisan serve`, `queue:listen`, `pail`, `npm run dev`)

---

## 📦 Jalur Instalasi & Pengoperasian

### 1. Prasyarat
- PHP >= 8.2 (dengan ekstensi composer)
- Node.js & npm
- Database Server (PostgreSQL / MySQL) atau SQLite

### 2. Langkah Instalasi

1. **Clone repository & masuk ke direktori**:
   ```bash
   git clone <repository-url> vettix-app
   cd vettix-app
   ```

3. **Jalankan Command Setup Otomatis** (meliputi `composer install`, `.env`, `key:generate`, `migrate`, `npm install`, `build`):
   ```bash
   composer run setup
   ```

4. **Konfigurasi Lingkungan (`.env`)**:
   Sesuaikan parameter koneksi database Anda di file `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=vettix_db
   DB_USERNAME=postgres
   DB_PASSWORD=yourpassword
   ```

5. **Menjalankan Seeder (Opsional)**:
   ```bash
   php artisan db:seed
   ```

### 3. Menjalankan Aplikasi

Jalankan server pengembangan lokal (meliputi Artisan Server, Vite Dev Server, Queue Listener, dan Laravel Pail) sekaligus:
```bash
composer dev
```

Aplikasi dapat diakses melalui browser di `http://127.0.0.1:8000`.

---

## 📁 Struktur Direktori Penting

```text
vettix-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller utama (Event, Venue, Participant, Speaker, dll.)
│   │   └── Controllers/Api/   # Controller REST API (EventApiController, VenueApiController)
│   └── Models/                # Model Eloquent (Event, Participant, Certificate, Speaker, dll.)
├── database/
│   ├── migrations/            # Struktur tabel database
│   └── seeders/               # Data awal database (termasuk PerformanceTestSeeder)
├── resources/
│   ├── views/                 # Blade Templates (layouts, dashboard, events, venues, dll.)
│   ├── css/ & js/             # Asset frontend (Vite & Tailwind CSS)
├── routes/
│   ├── web.php                # Route antarmuka Web & Auth
│   └── api.php                # Route REST API
└── scripts/
    └── 00-laravel-deploy.sh   # Script otomasi deployment
```

---

## 🧪 Testing

Jalankan suite pengujian menggunakan Artisan Test:
```bash
composer test
# atau
php artisan test
```

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](LICENSE).
