<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Ujian extends Model
{
    protected $fillable = [
        'sekolah_id',
        'kategori_id',
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'nama_ujian',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Boot the model and add global scope for sekolah filtering
     */
    protected static function booted(): void
    {
        static::addGlobalScope('sekolah', function (Builder $builder) {
            if (session()->has('sekolah_id')) {
                $builder->where('ujians.sekolah_id', session('sekolah_id'));
            }
        });

        // Auto-set sekolah_id on create
        static::creating(function ($model) {
            if (empty($model->sekolah_id) && session()->has('sekolah_id')) {
                $model->sekolah_id = session('sekolah_id');
            }
        });
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(UjianKategori::class, 'kategori_id');
    }
}
