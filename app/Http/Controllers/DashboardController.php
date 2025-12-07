<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Absen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'siswa' => Siswa::count(),
            'guru' => Guru::count(),
            'kelas' => Kelas::count(),
            'mapel' => MataPelajaran::count(),
        ];

        $recentAbsen = Absen::with(['siswa', 'jadwal.mataPelajaran'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'recentAbsen'));
    }
}
