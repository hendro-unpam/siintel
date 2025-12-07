<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absen extends Model
{
    protected $fillable = [
        'siswa_id',
        'jadwal_id',
        'tgl',
        'ket',
        'updated_by_name',
        'updated_by_role',
    ];

    protected $casts = [
        'tgl' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    // Helper method to get status label
    public function getStatusLabelAttribute(): string
    {
        return match($this->ket) {
            'M' => 'Masuk',
            'S' => 'Sakit',
            'I' => 'Izin',
            'A' => 'Alpa',
            default => 'Unknown',
        };
    }
}
