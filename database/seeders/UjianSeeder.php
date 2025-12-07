<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujian;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use Carbon\Carbon;

class UjianSeeder extends Seeder
{
    public function run()
    {
        // Get all schools (by kelas sekolah_id)
        $kelasAll = Kelas::with('siswas')->get();
        $gurus = Guru::all();
        $mapels = MataPelajaran::all();

        if ($kelasAll->isEmpty()) {
            $this->command->warn('No Kelas found. Run SchoolDataSeeder first.');
            return;
        }

        $ujianTypes = ['UTS', 'UAS', 'UH 1', 'UH 2', 'Tugas 1', 'Kuis'];

        foreach ($kelasAll as $kelas) {
            // Skip if no siswa
            if ($kelas->siswas->isEmpty()) continue;

            // Get a guru from same school
            $guru = $gurus->where('sekolah_id', $kelas->sekolah_id)->first();
            if (!$guru) continue;

            // Get a random mapel
            $mapel = $mapels->random();
            
            // Create 2 Ujians per kelas
            for ($i = 0; $i < 2; $i++) {
                $ujian = Ujian::create([
                    'sekolah_id' => $kelas->sekolah_id,
                    'guru_id' => $guru->id,
                    'kelas_id' => $kelas->id,
                    'mata_pelajaran_id' => $mapel->id,
                    'nama_ujian' => $ujianTypes[array_rand($ujianTypes)] . ' ' . $mapel->nama_mp,
                    'tanggal' => Carbon::now()->subDays(rand(1, 30)),
                    'keterangan' => 'Ujian semester ' . date('Y'),
                ]);

                // Input nilai for each siswa
                foreach ($kelas->siswas as $siswa) {
                    Nilai::create([
                        'sekolah_id' => $kelas->sekolah_id,
                        'ujian_id' => $ujian->id,
                        'siswa_id' => $siswa->id,
                        'nilai' => rand(50, 100),
                        'catatan' => rand(0, 1) ? 'Baik' : null,
                    ]);
                }

                $this->command->info("Created Ujian: {$ujian->nama_ujian} for {$kelas->nama}");
            }
        }
    }
}
