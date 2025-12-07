<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Hari;
use App\Models\Jadwal;
use App\Models\Pekerjaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@siintel.com',
            'password' => Hash::make('password'),
        ]);

        // Create Sekolah
        $sekolah = Sekolah::create([
            'kode' => '2010902872872',
            'nama' => 'SMP Negeri 3 Bandung',
            'alamat' => 'Jl. AH Nasution No. 16 Bandung Timur, Bandung 46042',
            'kepala' => 'Dr. H. Ahmad Yani, M.Pd',
        ]);

        // Create Hari
        $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        foreach ($haris as $hari) {
            Hari::create(['hari' => $hari]);
        }

        // Create Mata Pelajaran
        $mapels = [
            'Matematika',
            'Bahasa Indonesia',
            'Ilmu Pengetahuan Alam',
            'Bahasa Inggris',
            'Pendidikan Kewarganegaraan',
        ];
        foreach ($mapels as $mapel) {
            MataPelajaran::create(['nama_mp' => $mapel]);
        }

        // Create Pekerjaan (Jobs)
        $pekerjaanData = [
            ['nama' => 'Pegawai Negeri Sipil', 'keterangan' => 'PNS'],
            ['nama' => 'Wiraswasta', 'keterangan' => 'Usaha sendiri'],
            ['nama' => 'Karyawan Swasta', 'keterangan' => 'Perusahaan swasta'],
            ['nama' => 'TNI/Polri', 'keterangan' => 'Tentara/Polisi'],
            ['nama' => 'Guru/Dosen', 'keterangan' => 'Pendidik'],
            ['nama' => 'Dokter', 'keterangan' => 'Tenaga medis'],
            ['nama' => 'Petani', 'keterangan' => 'Pertanian'],
            ['nama' => 'Pedagang', 'keterangan' => 'Jual beli'],
            ['nama' => 'Buruh', 'keterangan' => 'Pekerja harian'],
            ['nama' => 'Ibu Rumah Tangga', 'keterangan' => 'IRT'],
            ['nama' => 'Tidak Bekerja', 'keterangan' => '-'],
            ['nama' => 'Lainnya', 'keterangan' => 'Pekerjaan lainnya'],
        ];
        $pekerjaans = [];
        foreach ($pekerjaanData as $pekerjaan) {
            $pekerjaans[] = Pekerjaan::create($pekerjaan);
        }

        // Create Guru
        $guruData = [
            ['nip' => '19610506199', 'nama' => 'Drs. Bayu Pratama', 'jk' => 'L', 'alamat' => 'Bandung'],
            ['nip' => '19540914972', 'nama' => 'Dra. Hj. Latifah', 'jk' => 'P', 'alamat' => 'Bandung'],
            ['nip' => '19661025191', 'nama' => 'Yasin, S.Pd', 'jk' => 'L', 'alamat' => 'Bandung'],
            ['nip' => '34547566583', 'nama' => 'Ibnu, S.Pd', 'jk' => 'L', 'alamat' => 'Bandung'],
            ['nip' => '34627426463', 'nama' => 'Drs. Masrur', 'jk' => 'L', 'alamat' => 'Bandung'],
        ];
        foreach ($guruData as $guru) {
            Guru::create([
                ...$guru,
                'password' => Hash::make('password'),
            ]);
        }

        // Create Kelas
        $kelasNames = ['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'];
        foreach ($kelasNames as $kelasName) {
            Kelas::create([
                'sekolah_id' => $sekolah->id,
                'nama' => $kelasName,
            ]);
        }

        // Create Siswa with pekerjaan references
        $siswaData = [
            ['nis' => '9965340897', 'nama' => 'Ahmad Zildjian', 'jk' => 'L', 'kelas_id' => 1, 'bapak' => 'Ahmad Sr.', 'ibu' => 'Siti Aminah', 'pekerjaan_ayah_id' => 1, 'pekerjaan_ibu_id' => 10],
            ['nis' => '9974601836', 'nama' => 'Mitra Dewi', 'jk' => 'P', 'kelas_id' => 1, 'bapak' => 'Budi Santoso', 'ibu' => 'Dewi Lestari', 'pekerjaan_ayah_id' => 2, 'pekerjaan_ibu_id' => 10],
            ['nis' => '9974601924', 'nama' => 'Dhea Ananda', 'jk' => 'P', 'kelas_id' => 1, 'bapak' => 'Andi Wijaya', 'ibu' => 'Rina Marlina', 'pekerjaan_ayah_id' => 3, 'pekerjaan_ibu_id' => 5],
            ['nis' => '9974601993', 'nama' => 'Armando Putra', 'jk' => 'L', 'kelas_id' => 2, 'bapak' => 'Joko Susilo', 'ibu' => 'Sri Wahyuni', 'pekerjaan_ayah_id' => 4, 'pekerjaan_ibu_id' => 10],
            ['nis' => '9974602034', 'nama' => 'Yunaz Pratama', 'jk' => 'L', 'kelas_id' => 2, 'bapak' => 'Hendra Pratama', 'ibu' => 'Maya Sari', 'pekerjaan_ayah_id' => 6, 'pekerjaan_ibu_id' => 6],
            ['nis' => '9974602051', 'nama' => 'Susanto', 'jk' => 'L', 'kelas_id' => 3, 'bapak' => 'Suparman', 'ibu' => 'Suparni', 'pekerjaan_ayah_id' => 7, 'pekerjaan_ibu_id' => 10],
            ['nis' => '9974602083', 'nama' => 'Rani Safitri', 'jk' => 'P', 'kelas_id' => 3, 'bapak' => 'Rahman', 'ibu' => 'Fatimah', 'pekerjaan_ayah_id' => 8, 'pekerjaan_ibu_id' => 8],
            ['nis' => '9974602096', 'nama' => 'Hardianti', 'jk' => 'P', 'kelas_id' => 4, 'bapak' => 'Hardi', 'ibu' => 'Muslimah', 'pekerjaan_ayah_id' => 9, 'pekerjaan_ibu_id' => 10],
            ['nis' => '9974603377', 'nama' => 'Ari Nugraha', 'jk' => 'L', 'kelas_id' => 5, 'bapak' => 'Nugroho', 'ibu' => 'Ratna', 'pekerjaan_ayah_id' => 1, 'pekerjaan_ibu_id' => 1],
            ['nis' => '9985109543', 'nama' => 'Adit Firmansyah', 'jk' => 'L', 'kelas_id' => 6, 'bapak' => 'Firman', 'ibu' => 'Ayu Lestari', 'pekerjaan_ayah_id' => 2, 'pekerjaan_ibu_id' => 3],
        ];
        foreach ($siswaData as $siswa) {
            Siswa::create([
                ...$siswa,
                'alamat' => 'Bandung',
                'tlp' => '08123456789',
                'password' => Hash::make('password'),
            ]);
        }

        // Create sample Jadwal
        $jadwalData = [
            ['hari_id' => 1, 'guru_id' => 1, 'kelas_id' => 1, 'mata_pelajaran_id' => 1, 'jam_mulai' => '07:00', 'jam_selesai' => '09:00'],
            ['hari_id' => 1, 'guru_id' => 2, 'kelas_id' => 2, 'mata_pelajaran_id' => 2, 'jam_mulai' => '09:00', 'jam_selesai' => '11:00'],
            ['hari_id' => 2, 'guru_id' => 3, 'kelas_id' => 1, 'mata_pelajaran_id' => 3, 'jam_mulai' => '07:00', 'jam_selesai' => '09:00'],
            ['hari_id' => 2, 'guru_id' => 4, 'kelas_id' => 3, 'mata_pelajaran_id' => 4, 'jam_mulai' => '10:00', 'jam_selesai' => '12:00'],
            ['hari_id' => 3, 'guru_id' => 5, 'kelas_id' => 5, 'mata_pelajaran_id' => 5, 'jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
        ];
        foreach ($jadwalData as $jadwal) {
            Jadwal::create([
                ...$jadwal,
                'aktif' => true,
            ]);
        }
    }
}
