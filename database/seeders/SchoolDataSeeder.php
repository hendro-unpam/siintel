<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Hari;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SchoolDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Hari exists
        $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($haris as $h) {
            Hari::firstOrCreate(['hari' => $h]);
        }

        // 2. Define Schools (Assuming IDs 1=TK, 2=SD, 3=SMP exist)
        $schools = [
            1 => ['level' => 'TK', 'classes' => ['TK A', 'TK B'], 'subjects' => ['Bermain', 'Menyanyi', 'Menggambar', 'Berhitung Dasar']],
            2 => ['level' => 'SD', 'classes' => ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'], 'subjects' => ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'PKn', 'Agama']],
            3 => ['level' => 'SMP', 'classes' => ['Kelas 7', 'Kelas 8', 'Kelas 9'], 'subjects' => ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 'Biologi', 'Sejarah']]
        ];

        $password = Hash::make('password');

        foreach ($schools as $sekolahId => $data) {
            $sekolah = Sekolah::find($sekolahId);
            if (!$sekolah) continue;

            $this->command->info("Seeding data for {$sekolah->nama}...");

            // Create Subjects (Global for now, but we track IDs)
            $subjectIds = [];
            foreach ($data['subjects'] as $subjectName) {
                $mapel = MataPelajaran::firstOrCreate(['nama_mp' => $subjectName]);
                $subjectIds[] = $mapel->id;
            }

            // Create Teachers (2 teachers per school for demo)
            $guruIds = [];
            for ($i = 1; $i <= 3; $i++) {
                $nip = $sekolahId . '00' . $i; // Simple NIP generation
                $guru = Guru::firstOrCreate(
                    ['nip' => $nip],
                    [
                        'nama' => "Guru {$data['level']} {$i}",
                        'password' => $password,
                        'jk' => $i % 2 == 0 ? 'P' : 'L',
                        'alamat' => 'Jl. Guru No. ' . $i,
                        'sekolah_id' => $sekolahId
                    ]
                );
                $guruIds[] = $guru->id;
            }

            // Create Classes & Students
            foreach ($data['classes'] as $className) {
                $kelas = Kelas::firstOrCreate(
                    ['nama' => $className, 'sekolah_id' => $sekolahId]
                );

                // Create 5 Students per class
                for ($j = 1; $j <= 5; $j++) {
                    $nis = $sekolahId . $kelas->id . '00' . $j;
                    Siswa::firstOrCreate(
                        ['nis' => $nis],
                        [
                            'nama' => "Siswa {$className} {$j}",
                            'password' => $password,
                            'jk' => $j % 2 == 0 ? 'P' : 'L',
                            'alamat' => 'Jl. Siswa No. ' . $j,
                            'kelas_id' => $kelas->id,
                            'sekolah_id' => $sekolahId,
                            // 'tgl_lahir' removed as it's not in fillable
                        ]
                    );
                }

                // Create Schedule for this class
                // Assign random subjects and teachers
                foreach (Hari::all() as $hari) {
                    // 2 subjects per day
                    for ($k = 0; $k < 2; $k++) {
                        Jadwal::firstOrCreate([
                            'hari_id' => $hari->id,
                            'kelas_id' => $kelas->id,
                            'jam_mulai' => Carbon::createFromTime(8 + ($k * 2), 0)->format('H:i'),
                        ], [
                            'guru_id' => $guruIds[array_rand($guruIds)],
                            'jam_selesai' => Carbon::createFromTime(10 + ($k * 2), 0)->format('H:i'),
                            'mata_pelajaran_id' => $subjectIds[array_rand($subjectIds)]
                        ]);
                    }
                }
            }
        }
    }
}
