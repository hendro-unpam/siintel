<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Show grades for logged-in student
     */
    public function siswaIndex()
    {
        $siswaId = session('siswa_id');
        
        if (!$siswaId) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda tidak terautentikasi sebagai siswa.');
        }

        $nilais = Nilai::with(['ujian.mataPelajaran', 'ujian.guru', 'ujian.kelas'])
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('nilai.siswa_index', compact('nilais'));
    }
}
