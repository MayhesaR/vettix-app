<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Venue / Ruangan Kampus</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333333;
            line-height: 1.5;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1e3a8a;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #666666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
        }
        .venue-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .venue-table th {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .venue-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        .venue-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAFTAR VENUE / RUANGAN KAMPUS</h1>
        <p>Vettix - Sistem Informasi Manajemen Event Terpadu</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%"><strong>Laporan:</strong> Daftar Inventori Ruangan Kampus</td>
            <td width="50%" align="right"><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</td>
        </tr>
    </table>

    <table class="venue-table">
        <thead>
            <tr>
                <th width="30%">Nama Ruangan</th>
                <th width="20%">Gedung / Bangunan</th>
                <th width="15%">Kapasitas</th>
                <th width="15%">Status</th>
                <th width="20%">Fasilitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($venues as $venue)
                <tr>
                    <td><strong>{{ $venue->nama_venue }}</strong></td>
                    <td>{{ $venue->gedung }}</td>
                    <td>{{ $venue->kapasitas }} Kursi</td>
                    <td>
                        <span class="badge badge-success">
                            Tersedia
                        </span>
                    </td>
                    <td>{{ $venue->fasilitas ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center" style="padding: 20px; color: #666666;">
                        Tidak ada data ruangan yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini diterbitkan secara otomatis oleh Vettix Event Portal. &copy; {{ date('Y') }} Vettix. All rights reserved.
    </div>
</body>
</html>
