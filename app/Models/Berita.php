<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'sekolah_id',
        'judul',
        'konten',
        'gambar',
        'penulis',
        'tanggal_post',
        'views',
    ];

    protected $casts = [
        'tanggal_post' => 'date',
    ];

    /**
     * Boot the model and add global scope for sekolah filtering
     */
    protected static function booted(): void
    {
        static::addGlobalScope('sekolah', function (Builder $builder) {
            if (session()->has('sekolah_id')) {
                $builder->where('berita.sekolah_id', session('sekolah_id'));
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
