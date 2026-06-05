<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participant;
use App\Models\Event;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        $event1 = Event::find(1);
        $event2 = Event::find(2);
        $event3 = Event::find(3);

        $event1Id = $event1 ? $event1->id : 1;
        $event2Id = $event2 ? $event2->id : 2;
        $event3Id = $event3 ? $event3->id : 3;

        $participants = [
            ['nama_peserta' => 'Budi Santoso', 'nim' => '1301210001', 'email' => 'budi@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event1Id],
            ['nama_peserta' => 'Siti Aminah', 'nim' => '1301210002', 'email' => 'siti@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event1Id],
            ['nama_peserta' => 'Ahmad Fadli', 'nim' => '1301210003', 'email' => 'ahmad@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event1Id],
            ['nama_peserta' => 'Rina Wati', 'nim' => '1301210004', 'email' => 'rina@student.itb.ac.id', 'asal_instansi' => 'ITB Bandung', 'status_kehadiran' => 'tidak_hadir', 'event_id' => $event1Id],

            ['nama_peserta' => 'Doni Prakoso', 'nim' => '1301210005', 'email' => 'doni@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event2Id],
            ['nama_peserta' => 'Lisa Permata', 'nim' => '1301210006', 'email' => 'lisa@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event2Id],
            ['nama_peserta' => 'Rama Wijaya', 'nim' => '1301210007', 'email' => 'rama@student.unpad.ac.id', 'asal_instansi' => 'Universitas Padjadjaran', 'status_kehadiran' => 'hadir', 'event_id' => $event2Id],

            ['nama_peserta' => 'Indah Sari', 'nim' => '1301210008', 'email' => 'indah@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event3Id],
            ['nama_peserta' => 'Fajar Nugraha', 'nim' => '1301210009', 'email' => 'fajar@student.telkomuniversity.ac.id', 'asal_instansi' => 'Telkom University', 'status_kehadiran' => 'hadir', 'event_id' => $event3Id],
            ['nama_peserta' => 'Putri Anggraini', 'nim' => '1301210010', 'email' => 'putri@student.ui.ac.id', 'asal_instansi' => 'Universitas Indonesia', 'status_kehadiran' => 'hadir', 'event_id' => $event3Id],
            ['nama_peserta' => 'Andi Saputra', 'nim' => '1301210011', 'email' => 'andi@student.ugm.ac.id', 'asal_instansi' => 'Universitas Gadjah Mada', 'status_kehadiran' => 'hadir', 'event_id' => $event3Id],
        ];

        foreach ($participants as $p) {
            Participant::create($p);
        }
    }
}
