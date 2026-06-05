<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Event Kampus - {{ $currentMonthName }}</title>
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
        .event-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .event-table th {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .event-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        .event-table tr:nth-child(even) {
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
        .badge-seminar { background-color: #fee2e2; color: #ef4444; }
        .badge-workshop { background-color: #ecfccb; color: #84cc16; }
        .badge-lomba { background-color: #ecfeff; color: #06b6d4; }
        .badge-konf { background-color: #f3e8ff; color: #a855f7; }
        .badge-default { background-color: #f1f5f9; color: #64748b; }
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
        <h1>JADWAL EVENT KAMPUS</h1>
        <p>Vettix - Sistem Informasi Manajemen Event Terpadu</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Periode:</strong></td>
            <td width="35%">{{ $currentMonthName }}</td>
            <td width="25%" align="right"><strong>Tanggal Cetak:</strong></td>
            <td width="25%" align="right">{{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</td>
        </tr>
    </table>

    <table class="event-table">
        <thead>
            <tr>
                <th width="20%">Tanggal</th>
                <th width="35%">Nama Event</th>
                <th width="20%">Kategori</th>
                <th width="25%">Lokasi (Venue)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                @php
                    $badgeClass = match($event->category_id) {
                        1 => 'badge-seminar',
                        2 => 'badge-workshop',
                        3 => 'badge-lomba',
                        4 => 'badge-konf',
                        default => 'badge-default'
                    };
                @endphp
                <tr>
                    <td><strong>{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}</strong></td>
                    <td>{{ $event->nama_event }}</td>
                    <td>
                        <span class="badge {{ $badgeClass }}">
                            {{ $event->category->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td>{{ $event->venue->nama_venue ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center" style="padding: 20px; color: #666666;">
                        Tidak ada event yang dijadwalkan pada periode ini.
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
