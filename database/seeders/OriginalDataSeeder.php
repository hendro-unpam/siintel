<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\Ekstrakurikuler;
use App\Models\Sekolah;

class OriginalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Migrates data from original insan-teladan school_db
     */
    public function run(): void
    {
        // Find sekolah_id for SD (or use default)
        $sekolah = Sekolah::where('nama', 'LIKE', '%SD%')->first();
        $sekolahId = $sekolah ? $sekolah->id : 1;

        // Clear existing data first
        Berita::withoutGlobalScopes()->delete();
        Prestasi::withoutGlobalScopes()->delete();
        Ekstrakurikuler::withoutGlobalScopes()->delete();

        // === BERITA DATA ===
        $beritaData = [
            [
                'judul' => '🏆 Kemenangan Gemilang: Siswa Insan Teladan Raih Medali Emas Robotika Tingkat Nasional',
                'konten' => 'Jakarta, 20 November 2025 - Kabar membanggakan datang dari dunia pendidikan teknologi Indonesia. Gilang Permana Putra, siswa berprestasi dari Kelas 9A SMP Insan Teladan, sukses meraih Medali Emas dalam ajang kompetisi robotika bergengsi tingkat nasional.

Gilang berhasil mengungguli puluhan peserta lain dari berbagai sekolah unggulan di seluruh Indonesia berkat inovasi dan keterampilan merakit serta memprogram robotnya.

Detail Prestasi
Nama Pemenang: Gilang Permana Putra
Sekolah/Kelas: SMP Insan Teladan, Kelas 9A
Prestasi: Medali Emas Lomba Robotika Tingkat Nasional
Tanggal: 20 November 2025

Kemenangan ini menegaskan komitmen SMP Insan Teladan dalam mengembangkan potensi siswa di bidang Sains, Teknologi, Engineering, dan Matematika (STEM).',
                'gambar' => 'berita/691f0454b17ab_1763640404.jpg',
                'penulis' => 'Yudistira Tanjung S.Kom., M.T',
                'tanggal_post' => '2025-11-20',
                'views' => 2,
                'sekolah_id' => $sekolahId,
            ],
            [
                'judul' => '🎓 Kolaborasi Pendidikan: Mahasiswa UNPAM Laksanakan Program Magang di Sekolah Insan Teladan',
                'konten' => 'Tangerang Selatan, 20 November 2025 – Universitas Pamulang (UNPAM) memperkuat sinergi antara dunia akademik dan praktik kerja dengan mengirimkan sejumlah mahasiswa untuk melaksanakan Program Magang/Praktik Kerja Lapangan (PKL) di Sekolah Insan Teladan.

Kunjungan perdana dan serah terima mahasiswa magang ini dilaksanakan pada hari ini, Kamis, 20 November 2025, di lingkungan Sekolah Insan Teladan.

Program magang ini merupakan bagian integral dari kurikulum UNPAM yang bertujuan memberikan pengalaman nyata kepada mahasiswa dalam menerapkan teori yang dipelajari di bangku kuliah ke dalam lingkungan kerja profesional, khususnya bidang pendidikan.',
                'gambar' => 'berita/691f0910ba72d_1763641616.jpg',
                'penulis' => 'Yudistira Tanjung S.Kom., M.T',
                'tanggal_post' => '2025-11-20',
                'views' => 0,
                'sekolah_id' => $sekolahId,
            ],
            [
                'judul' => 'Penanaman 1000 Pohon',
                'konten' => 'Ibu Sri telah berhasil menanam 1000 pohon dalam satu hari dengan melibatkan para relawan.',
                'gambar' => null,
                'penulis' => 'Ibu Sri Handayani',
                'tanggal_post' => '2025-12-04',
                'views' => 0,
                'sekolah_id' => $sekolahId,
            ],
        ];

        foreach ($beritaData as $berita) {
            Berita::create($berita);
        }

        // === PRESTASI DATA ===
        $prestasiData = [
            [
                'judul' => '🏆 Kemenangan Gemilang: Siswa Insan Teladan Raih Medali Emas Robotika Tingkat Nasional',
                'kategori' => 'non_akademik',
                'nama_siswa' => 'Gilang Permana Putra',
                'kelas' => '9A',
                'deskripsi' => 'Jakarta, 20 November 2025 - Gilang Permana Putra berhasil meraih Medali Emas dalam ajang kompetisi robotika bergengsi tingkat nasional.',
                'gambar' => 'prestasi/691f03ede0580_1763640301.jpg',
                'tanggal' => '2025-11-20',
                'sekolah_id' => $sekolahId,
            ],
            [
                'judul' => '🧠 Tiga Pilar Akademik Insan Teladan: Ajeng, Gilang, dan Yudistira Unggul di Kancah Nasional',
                'kategori' => 'akademik',
                'nama_siswa' => 'Ajeng, Gilang, dan Yudistira',
                'kelas' => '9A',
                'deskripsi' => 'Kelas 9A Sekolah Insan Teladan terbukti menjadi gudang talenta akademik yang unggul.',
                'gambar' => 'prestasi/691f0874cea51_1763641460.webp',
                'tanggal' => '2025-11-20',
                'sekolah_id' => $sekolahId,
            ],
            [
                'judul' => 'Juara Lomba Lari dari kenyataan',
                'kategori' => 'non_akademik',
                'nama_siswa' => 'budi',
                'kelas' => '7B',
                'deskripsi' => 'Juara lomba lari tingkat kecamatan.',
                'gambar' => null,
                'tanggal' => '2025-12-01',
                'sekolah_id' => $sekolahId,
            ],
        ];

        foreach ($prestasiData as $prestasi) {
            Prestasi::create($prestasi);
        }

        // === EKSTRAKURIKULER DATA ===
        $ekskulData = [
            [
                'nama' => 'Pramuka',
                'deskripsi' => 'Kegiatan kepramukaan untuk membentuk karakter kepemimpinan dan kemandirian siswa',
                'pembina' => 'Rudi Hartono, S.Pd',
                'jadwal' => 'Setiap Jumat, 14:00-16:00',
                'gambar' => null,
                'sekolah_id' => $sekolahId,
            ],
            [
                'nama' => 'Marching Band',
                'deskripsi' => 'Latihan marching band untuk mengembangkan bakat seni musik dan kekompakan tim',
                'pembina' => 'Fitri Handayani, S.Pd',
                'jadwal' => 'Selasa & Kamis, 15:00-17:00',
                'gambar' => null,
                'sekolah_id' => $sekolahId,
            ],
            [
                'nama' => 'Futsal',
                'deskripsi' => 'Olahraga futsal untuk meningkatkan kesehatan dan sportivitas',
                'pembina' => 'Rudi Hartono, S.Pd',
                'jadwal' => 'Senin & Rabu, 15:30-17:00',
                'gambar' => null,
                'sekolah_id' => $sekolahId,
            ],
        ];

        foreach ($ekskulData as $ekskul) {
            Ekstrakurikuler::create($ekskul);
        }

        $this->command->info('Original data migrated successfully!');
    }
}
