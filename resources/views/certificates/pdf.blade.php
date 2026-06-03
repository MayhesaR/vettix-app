<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $no_sertifikat }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 842pt;
            height: 595pt;
            font-family: 'Helvetica', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            -webkit-print-color-adjust: exact;
        }
        .certificate-wrapper {
            position: relative;
            width: 842pt;
            height: 595pt;
            background-color: #f8fafc;
            overflow: hidden;
        }
        .outer-border {
            position: absolute;
            top: 35pt;
            left: 35pt;
            right: 35pt;
            bottom: 35pt;
            border: 6pt solid #00c2cb;
            box-sizing: border-box;
        }
        .inner-border {
            position: absolute;
            top: 6pt;
            left: 6pt;
            right: 6pt;
            bottom: 6pt;
            border: 2pt solid #00a4ad;
            background-color: #ffffff;
            box-sizing: border-box;
            padding: 30pt 45pt;
            text-align: center;
        }
        /* Decorative Corners */
        .corner {
            position: absolute;
            width: 25pt;
            height: 25pt;
            border-color: #00c2cb;
            border-style: solid;
        }
        .corner-tl { top: 0; left: 0; border-width: 5pt 0 0 5pt; }
        .corner-tr { top: 0; right: 0; border-width: 5pt 5pt 0 0; }
        .corner-bl { bottom: 0; left: 0; border-width: 0 0 5pt 5pt; }
        .corner-br { bottom: 0; right: 0; border-width: 0 5pt 5pt 0; }

        /* Certificate Content Styling */
        .brand-header {
            font-size: 14pt;
            font-weight: bold;
            color: #00a4ad;
            letter-spacing: 2pt;
            margin-bottom: 15pt;
        }
        .title-main {
            font-size: 34pt;
            font-weight: 700;
            color: #0f172a;
            margin: 5pt 0;
            letter-spacing: 3pt;
        }
        .title-sub {
            font-size: 12pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 5pt;
            margin-bottom: 25pt;
        }
        .presented-to {
            font-size: 14pt;
            color: #475569;
            font-style: italic;
            margin-bottom: 8pt;
        }
        .recipient-name {
            font-size: 30pt;
            font-weight: bold;
            color: #008f96;
            border-bottom: 2pt solid #e2e8f0;
            display: inline-block;
            padding-bottom: 6pt;
            margin-bottom: 18pt;
            min-width: 400pt;
        }
        .description {
            font-size: 14pt;
            line-height: 1.5;
            color: #334155;
            max-width: 650pt;
            margin: 0 auto;
        }
        .event-name {
            font-size: 16pt;
            font-weight: bold;
            color: #0f172a;
            display: block;
            margin-top: 6pt;
        }

        /* Footer signatures & QR code (direct child of certificate-wrapper to prevent absolute nesting bugs in DomPDF) */
        .cert-footer {
            position: absolute;
            bottom: 60pt;
            left: 80pt;
            right: 80pt;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .footer-table td {
            width: 33.33%;
            vertical-align: bottom;
            text-align: center;
            border: none;
            padding: 0;
        }
        .signature-line {
            width: 160pt;
            border-bottom: 1pt solid #94a3b8;
            margin: 0 auto 6pt auto;
        }
        .signer-name {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
        }
        .signer-title {
            font-size: 10pt;
            color: #64748b;
        }
        .qr-code-box img {
            width: 75pt;
            height: 75pt;
            border: 1px solid #e2e8f0;
            padding: 3pt;
            background-color: #ffffff;
        }
        .cert-number {
            font-size: 11pt;
            color: #64748b;
            margin-top: 6pt;
        }
    </style>
</head>
<body>

    <div class="certificate-wrapper">
        <div class="outer-border">
            <div class="inner-border">
                
                <!-- Corner Elements -->
                <div class="corner corner-tl"></div>
                <div class="corner corner-tr"></div>
                <div class="corner corner-bl"></div>
                <div class="corner corner-br"></div>

                <!-- Brand logo header -->
                <div class="brand-header">VETTIX PLATFORM</div>

                <!-- Main titles -->
                <div class="title-main">SERTIFIKAT PENGHARGAAN</div>
                <div class="title-sub">CERTIFICATE OF APPRECIATION</div>

                <div class="presented-to">Diberikan kepada / Presented to:</div>
                <div class="recipient-name">{{ $participant->nama_peserta }}</div>

                <div class="description">
                    Atas partisipasi aktifnya sebagai <strong>Peserta</strong> dalam menyukseskan kegiatan:
                    <span class="event-name">"{{ $event->nama_event }}"</span>
                    <div style="font-size: 12px; color: #64748b; margin-top: 8px;">
                        Diselenggarakan pada {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d F Y') }} di {{ $event->venue->nama_venue ?? 'Tempat Event' }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Signatures & Verification (Placed outside inner/outer border to avoid absolute nesting bugs in DomPDF) -->
        <div class="cert-footer">
            <table class="footer-table">
                <tr>
                    <!-- Signature 1 -->
                    <td>
                        <div style="margin-bottom: 35pt; font-style: italic; color: #94a3b8; font-size: 10pt;">[ Tanda Tangan ]</div>
                        <div class="signature-line"></div>
                        <div class="signer-name">Panitia Penyelenggara</div>
                        <div class="signer-title">Vettix Event Organizer</div>
                    </td>
                    
                    <!-- QR Code & Serial -->
                    <td>
                        <div class="qr-code-box">
                            <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code">
                        </div>
                        <div class="cert-number">No: {{ $no_sertifikat }}</div>
                    </td>

                    <!-- Signature 2 -->
                    <td>
                        <div style="margin-bottom: 35pt; font-style: italic; color: #94a3b8; font-size: 10pt;">[ Tanda Tangan ]</div>
                        <div class="signature-line"></div>
                        <div class="signer-name">Administrator Kampus</div>
                        <div class="signer-title">Layanan Akademik & IT</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
