<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate;
use App\Models\Participant;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $hadirParticipants = Participant::where('status_kehadiran', 'hadir')->get();

        foreach ($hadirParticipants as $index => $participant) {
            $no_sertifikat = 'SR-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . '/2025';
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($no_sertifikat);

            Certificate::create([
                'no_sertifikat' => $no_sertifikat,
                'file_path' => '/storage/certificates/' . $no_sertifikat . '.pdf',
                'qr_code_url' => $qrUrl,
                'participant_id' => $participant->id,
                'event_id' => $participant->event_id,
            ]);
        }
    }
}
