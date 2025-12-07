<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
        $query = Absen::with(['siswa', 'jadwal.mataPelajaran', 'jadwal.kelas']);
        
        // Apply filters
        if ($request->kelas_id) {
            $query->whereHas('jadwal', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->tgl_awal) {
            $query->whereDate('tgl', '>=', $request->tgl_awal);
        }
        if ($request->tgl_akhir) {
            $query->whereDate('tgl', '<=', $request->tgl_akhir);
        }
        if ($request->ket) {
            $query->where('ket', $request->ket);
        }
        
        $absens = $query->orderByDesc('tgl')->paginate(20);
        
        // Get stats
        $stats = [
            'masuk' => Absen::where('ket', 'M')->count(),
            'sakit' => Absen::where('ket', 'S')->count(),
            'izin' => Absen::where('ket', 'I')->count(),
            'alpa' => Absen::where('ket', 'A')->count(),
        ];
        
        $kelass = Kelas::orderBy('nama')->get();
        
        return view('absen.index', compact('absens', 'stats', 'kelass'));
    }

    public function create()
    {
        $jadwals = Jadwal::with(['hari', 'kelas', 'mataPelajaran'])
            ->where('aktif', true)
            ->get();
        $kelas = Kelas::all();
        return view('absen.create', compact('jadwals', 'kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tgl' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:siswas,id',
            'absensi.*.ket' => 'required|in:M,S,I,A',
        ]);

        $updatedByName = session('user_name', 'System');
        $updatedByRole = session('user_role', 'admin');

        foreach ($validated['absensi'] as $item) {
            Absen::updateOrCreate(
                [
                    'siswa_id' => $item['siswa_id'],
                    'jadwal_id' => $validated['jadwal_id'],
                    'tgl' => $validated['tgl'],
                ],
                [
                    'ket' => $item['ket'],
                    'updated_by_name' => $updatedByName,
                    'updated_by_role' => $updatedByRole,
                ]
            );
        }

        return redirect()->route('absen.index')
            ->with('success', 'Absensi berhasil disimpan!');
    }

    public function show(Absen $absen)
    {
        $absen->load(['siswa', 'jadwal.mataPelajaran', 'jadwal.guru']);
        return view('absen.show', compact('absen'));
    }

    public function edit(Absen $absen)
    {
        return view('absen.edit', compact('absen'));
    }

    public function update(Request $request, Absen $absen)
    {
        $validated = $request->validate([
            'ket' => 'required|in:M,S,I,A',
        ]);

        $absen->update($validated);

        return redirect()->route('absen.index')
            ->with('success', 'Absensi berhasil diperbarui!');
    }

    public function destroy(Absen $absen)
    {
        $absen->delete();

        return redirect()->route('absen.index')
            ->with('success', 'Absensi berhasil dihapus!');
    }

    // Get students by jadwal for AJAX
    public function getSiswaByJadwal(Request $request)
    {
        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $siswas = Siswa::where('kelas_id', $jadwal->kelas_id)->get();
        
        return response()->json($siswas);
    }

    // Input absensi form
    public function inputAbsen(Request $request)
    {
        $jadwals = Jadwal::with(['hari', 'kelas', 'mataPelajaran', 'guru'])
            ->where('aktif', true)
            ->get();
        
        $siswas = collect();
        $selectedJadwal = null;
        $tgl = $request->tgl ?? now()->format('Y-m-d');

        if ($request->jadwal_id) {
            $selectedJadwal = Jadwal::find($request->jadwal_id);
            if ($selectedJadwal) {
                $siswas = Siswa::where('kelas_id', $selectedJadwal->kelas_id)->get();
                
                // Get existing absen for this date and jadwal
                $existingAbsen = Absen::where('jadwal_id', $request->jadwal_id)
                    ->where('tgl', $tgl)
                    ->pluck('ket', 'siswa_id');
                
                $siswas = $siswas->map(function ($siswa) use ($existingAbsen) {
                    $siswa->existing_ket = $existingAbsen->get($siswa->id, 'M');
                    return $siswa;
                });
            }
        }

        return view('absen.input', compact('jadwals', 'siswas', 'selectedJadwal', 'tgl'));
    }

    public function exportExcel(Request $request)
    {
        $query = Absen::with(['siswa', 'jadwal.mataPelajaran', 'jadwal.kelas']);
        
        if ($request->kelas_id) {
            $query->whereHas('jadwal', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->tgl_awal) {
            $query->whereDate('tgl', '>=', $request->tgl_awal);
        }
        if ($request->tgl_akhir) {
            $query->whereDate('tgl', '<=', $request->tgl_akhir);
        }
        if ($request->ket) {
            $query->where('ket', $request->ket);
        }
        
        $absens = $query->orderByDesc('tgl')->get();
        
        // Transform data for JSON response
        $data = $absens->map(function($absen) {
            return [
                'Tanggal' => $absen->tgl->format('d/m/Y'),
                'Siswa' => $absen->siswa->nama ?? '-',
                'Kelas' => $absen->jadwal->kelas->nama ?? '-',
                'Mata Pelajaran' => $absen->jadwal->mataPelajaran->nama_mp ?? '-',
                'Status' => match($absen->ket) {
                    'M' => 'Masuk',
                    'S' => 'Sakit',
                    'I' => 'Izin',
                    'A' => 'Alpa',
                    default => '-'
                },
                'Diubah Oleh' => $absen->updated_by_name ?? '-',
                'Waktu Update' => $absen->updated_at->format('d/m/Y H:i'),
            ];
        });
        
        // Prepare filter info
        $filters = [];
        if ($request->kelas_id) {
            $kelas = Kelas::find($request->kelas_id);
            if ($kelas) $filters['Kelas'] = $kelas->nama;
        }
        if ($request->tgl_awal) {
            $filters['Dari Tanggal'] = \Carbon\Carbon::parse($request->tgl_awal)->format('d/m/Y');
        }
        if ($request->tgl_akhir) {
            $filters['Sampai Tanggal'] = \Carbon\Carbon::parse($request->tgl_akhir)->format('d/m/Y');
        }
        if ($request->ket) {
            $filters['Status'] = match($request->ket) {
                'M' => 'Masuk',
                'S' => 'Sakit',
                'I' => 'Izin',
                'A' => 'Alpa',
                default => $request->ket
            };
        }
        
        return response()->json([
            'school' => session('sekolah_nama', 'SiIntel'),
            'filters' => $filters,
            'data' => $data
        ]);
    }
}
