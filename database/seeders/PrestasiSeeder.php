<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = Sekolah::all();
        
        foreach ($sekolahs as $sekolah) {
            // Determine school level
            $namaLower = strtolower($sekolah->nama);
            $level = 'SD';
            if (str_contains($namaLower, 'tk')) {
                $level = 'TK';
            } elseif (str_contains($namaLower, 'smp')) {
                $level = 'SMP';
            }
            
            // Get kelas for this school
            $kelasList = Kelas::withoutGlobalScope('sekolah')
                ->where('sekolah_id', $sekolah->id)
                ->get();
            
            if ($kelasList->isEmpty()) {
                $this->command->warn("No kelas found for {$sekolah->nama}, skipping...");
                continue;
            }
            
            // Define prestasi templates per level
            $prestasiTemplates = $this->getPrestasiTemplates($level);
            
            foreach ($prestasiTemplates as $index => $template) {
                // Pick a random kelas
                $kelas = $kelasList->random();
                
                // Try to get a real siswa from that kelas
                $siswa = Siswa::withoutGlobalScope('sekolah')
                    ->where('kelas_id', $kelas->id)
                    ->inRandomOrder()
                    ->first();
                
                // Use real siswa if available, otherwise use template
                $namaSiswa = $siswa ? $siswa->nama : $template['nama_siswa'];
                $kelasNama = $kelas->nama;
                
                Prestasi::withoutGlobalScope('sekolah')->create([
                    'sekolah_id' => $sekolah->id,
                    'kelas_id' => $kelas->id,
                    'siswa_id' => $siswa?->id,
                    'judul' => $template['judul'],
                    'kategori' => $template['kategori'],
                    'nama_siswa' => $namaSiswa,
                    'kelas' => $kelasNama,
                    'deskripsi' => $template['deskripsi'],
                    'tanggal' => $template['tanggal'],
                ]);
            }
        }

        $this->command->info('Prestasi seeded successfully with real siswa data!');
    }
    
    private function getPrestasiTemplates(string $level): array
    {
        $templates = [
            'TK' => [
                [
                    'judul' => 'Juara 1 Lomba Mewarnai Tingkat Kecamatan',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Aisyah Putri Ramadhani',
                    'deskripsi' => 'Meraih juara 1 dalam lomba mewarnai yang diselenggarakan oleh Dinas Pendidikan Kecamatan. Peserta berasal dari 25 TK se-kecamatan.',
                    'tanggal' => '2025-03-15',
                ],
                [
                    'judul' => 'Juara 2 Lomba Hafalan Surat Pendek',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Muhammad Raffa Alfarizi',
                    'deskripsi' => 'Berhasil menghafal 10 surat pendek dengan tajwid yang baik dan benar dalam lomba tingkat kota.',
                    'tanggal' => '2025-04-20',
                ],
                [
                    'judul' => 'Juara 3 Cerdas Cermat TK Se-Kota',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Tim Cerdas Cermat TK',
                    'deskripsi' => 'Tim cerdas cermat TK berhasil meraih juara 3 dalam kompetisi tingkat kota dengan 50 peserta.',
                    'tanggal' => '2025-05-10',
                ],
                [
                    'judul' => 'Juara 1 Lomba Tari Kreasi',
                    'kategori' => 'non_akademik',
                    'nama_siswa' => 'Kelompok Tari TK',
                    'deskripsi' => 'Penampilan tari kreasi yang memukau dalam Festival Seni Anak TK tingkat kecamatan.',
                    'tanggal' => '2025-06-05',
                ],
                [
                    'judul' => 'Juara Harapan 1 Senam Sehat Ceria',
                    'kategori' => 'non_akademik',
                    'nama_siswa' => 'Tim Senam TK',
                    'deskripsi' => 'Kompak dan energik dalam perlombaan senam sehat ceria tingkat kecamatan.',
                    'tanggal' => '2025-07-12',
                ],
            ],
            'SD' => [
                [
                    'judul' => 'Juara 1 Olimpiade Matematika Tingkat Kota',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Gilang Permana Putra',
                    'deskripsi' => 'Mengharumkan nama sekolah dengan meraih medali emas dalam Olimpiade Matematika Tingkat Kota tahun 2025. Bersaing dengan 200 peserta.',
                    'tanggal' => '2025-02-28',
                ],
                [
                    'judul' => 'Juara 2 Lomba Cerdas Cermat IPA',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Tim IPA SD',
                    'deskripsi' => 'Tim cerdas cermat IPA berhasil meraih juara 2 dalam kompetisi tingkat provinsi.',
                    'tanggal' => '2025-04-15',
                ],
                [
                    'judul' => 'Juara 1 Lomba Bercerita Bahasa Indonesia',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Salsabila Nur Fadillah',
                    'deskripsi' => 'Penampilan memukau dalam lomba bercerita dengan tema kepahlawanan tingkat kecamatan.',
                    'tanggal' => '2025-05-22',
                ],
                [
                    'judul' => 'Juara 1 Lomba Robotika Tingkat Provinsi',
                    'kategori' => 'non_akademik',
                    'nama_siswa' => 'Tim Robotika SD',
                    'deskripsi' => 'Tim robotika berhasil membuat robot line follower terbaik dan memenangkan kompetisi tingkat provinsi.',
                    'tanggal' => '2025-06-18',
                ],
                [
                    'judul' => 'Juara 2 Turnamen Futsal Antar SD',
                    'kategori' => 'non_akademik',
                    'nama_siswa' => 'Tim Futsal SD',
                    'deskripsi' => 'Menunjukkan sportivitas dan kerja sama tim dalam turnamen futsal antar SD se-kecamatan.',
                    'tanggal' => '2025-08-05',
                ],
            ],
            'SMP' => [
                [
                    'judul' => 'Juara 1 Olimpiade Sains Nasional Bidang Fisika',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Ahmad Rizky Fauzan',
                    'deskripsi' => 'Meraih medali emas dalam OSN Fisika tingkat nasional setelah melalui seleksi ketat dari tingkat kabupaten dan provinsi.',
                    'tanggal' => '2025-09-15',
                ],
                [
                    'judul' => 'Juara 2 Lomba Karya Ilmiah Remaja',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'Tim KIR SMP',
                    'deskripsi' => 'Karya ilmiah tentang pengolahan sampah plastik menjadi bahan bakar alternatif berhasil meraih juara 2 tingkat provinsi.',
                    'tanggal' => '2025-07-20',
                ],
                [
                    'judul' => 'Juara 1 Debat Bahasa Inggris',
                    'kategori' => 'akademik',
                    'nama_siswa' => 'English Debate Team',
                    'deskripsi' => 'Tim debat bahasa Inggris berhasil memenangkan kompetisi tingkat kota dengan penampilan yang sangat impresif.',
                    'tanggal' => '2025-10-08',
                ],
                [
                    'judul' => 'Juara 1 Lomba Band Pelajar Se-Jawa Barat',
                    'kategori' => 'non_akademik',
                    'nama_siswa' => 'Insan Band',
                    'deskripsi' => 'Band pelajar membawakan lagu original tentang semangat belajar dan meraih juara 1.',
                    'tanggal' => '2025-11-12',
                ],
                [
                    'judul' => 'Juara 3 Kejuaraan Karate Tingkat Nasional',
                    'kategori' => 'non_akademik',
                    'nama_siswa' => 'Farhan Dwi Prasetyo',
                    'deskripsi' => 'Meraih medali perunggu dalam kategori kumite junior putra di Kejuaraan Karate Nasional.',
                    'tanggal' => '2025-08-25',
                ],
            ],
        ];
        
        return $templates[$level] ?? $templates['SD'];
    }
}
