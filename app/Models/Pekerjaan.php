<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $fillable = [
        'nama',
        'keterangan',
    ];

    public function siswaAyah()
    {
        return $this->hasMany(Siswa::class, 'pekerjaan_ayah_id');
    }

    public function siswaIbu()
    {
        return $this->hasMany(Siswa::class, 'pekerjaan_ibu_id');
    }
}
