<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UjianKategori;
use App\Models\Sekolah;

class UjianKategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['nama_kategori' => 'UTS', 'keterangan' => 'Ujian Tengah Semester'],
            ['nama_kategori' => 'UAS', 'keterangan' => 'Ujian Akhir Semester'],
            ['nama_kategori' => 'UH', 'keterangan' => 'Ulangan Harian'],
            ['nama_kategori' => 'Tugas', 'keterangan' => 'Tugas Harian/Mingguan'],
            ['nama_kategori' => 'Kuis', 'keterangan' => 'Kuis Singkat'],
            ['nama_kategori' => 'Praktik', 'keterangan' => 'Ujian Praktik'],
        ];

        $sekolahs = Sekolah::all();

        foreach ($sekolahs as $sekolah) {
            foreach ($kategoris as $kategori) {
                UjianKategori::firstOrCreate(
                    [
                        'sekolah_id' => $sekolah->id,
                        'nama_kategori' => $kategori['nama_kategori'],
                    ],
                    [
                        'keterangan' => $kategori['keterangan'],
                    ]
                );
            }
            $this->command->info("Created kategoris for: {$sekolah->nama}");
        }
    }
}
