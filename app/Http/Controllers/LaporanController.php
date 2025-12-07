<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('laporan.index', compact('kelas'));
    }

    public function absensiPerKelas(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan' => 'required|date_format:Y-m',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $bulan = $request->bulan;

        $siswas = Siswa::where('kelas_id', $kelas->id)->get();
        
        $laporan = [];
        foreach ($siswas as $siswa) {
            $absens = Absen::where('siswa_id', $siswa->id)
                ->whereYear('tgl', substr($bulan, 0, 4))
                ->whereMonth('tgl', substr($bulan, 5, 2))
                ->get();

            $laporan[] = [
                'siswa' => $siswa,
                'masuk' => $absens->where('ket', 'M')->count(),
                'sakit' => $absens->where('ket', 'S')->count(),
                'izin' => $absens->where('ket', 'I')->count(),
                'alpa' => $absens->where('ket', 'A')->count(),
                'total' => $absens->count(),
            ];
        }

        return view('laporan.absensi', compact('kelas', 'bulan', 'laporan'));
    }

    public function rekapBulanan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|date_format:Y-m',
        ]);

        $bulan = $request->bulan;

        $rekap = DB::table('absens')
            ->join('siswas', 'absens.siswa_id', '=', 'siswas.id')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->whereYear('absens.tgl', substr($bulan, 0, 4))
            ->whereMonth('absens.tgl', substr($bulan, 5, 2))
            ->select(
                'kelas.id as kelas_id',
                'kelas.nama as kelas_nama',
                DB::raw('COUNT(CASE WHEN absens.ket = "M" THEN 1 END) as masuk'),
                DB::raw('COUNT(CASE WHEN absens.ket = "S" THEN 1 END) as sakit'),
                DB::raw('COUNT(CASE WHEN absens.ket = "I" THEN 1 END) as izin'),
                DB::raw('COUNT(CASE WHEN absens.ket = "A" THEN 1 END) as alpa'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('kelas.id', 'kelas.nama')
            ->get();

        return view('laporan.rekap', compact('bulan', 'rekap'));
    }
}
