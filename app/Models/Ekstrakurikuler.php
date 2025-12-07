<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'sekolah_id',
        'nama',
        'deskripsi',
        'pembina',
        'jadwal',
        'gambar',
    ];

    /**
     * Boot the model and add global scope for sekolah filtering
     */
    protected static function booted(): void
    {
        static::addGlobalScope('sekolah', function (Builder $builder) {
            if (session()->has('sekolah_id')) {
                $builder->where('ekstrakurikuler.sekolah_id', session('sekolah_id'));
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
}
