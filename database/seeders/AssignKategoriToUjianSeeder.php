<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujian;
use App\Models\UjianKategori;

class AssignKategoriToUjianSeeder extends Seeder
{
    public function run()
    {
        // Get all ujians without kategori
        $ujians = Ujian::withoutGlobalScopes()->whereNull('kategori_id')->get();

        if ($ujians->isEmpty()) {
            $this->command->info('All ujians already have kategori assigned.');
            return;
        }

        foreach ($ujians as $ujian) {
            // Get random kategori from same school
            $kategori = UjianKategori::withoutGlobalScopes()
                ->where('sekolah_id', $ujian->sekolah_id)
                ->inRandomOrder()
                ->first();

            if ($kategori) {
                $ujian->update(['kategori_id' => $kategori->id]);
                $this->command->info("Assigned '{$kategori->nama_kategori}' to '{$ujian->nama_ujian}'");
            }
        }

        $this->command->info('Done! All ujians now have kategori.');
    }
}
