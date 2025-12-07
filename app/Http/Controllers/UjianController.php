<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\UjianKategori;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function index(Request $request)
    {
        $query = Ujian::with(['guru', 'kelas', 'mataPelajaran', 'kategori']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $ujians = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();
        $kelass = Kelas::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama_mp')->get();
        $kategoris = UjianKategori::orderBy('nama_kategori')->get();

        return view('ujian.index', compact('ujians', 'kelass', 'mapels', 'kategoris'));
    }

    public function create()
    {
        $kelass = Kelas::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama_mp')->get();
        $kategoris = UjianKategori::orderBy('nama_kategori')->get();

        return view('ujian.create', compact('kelass', 'gurus', 'mapels', 'kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'nullable|exists:ujian_kategoris,id',
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nama_ujian' => 'required|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $ujian = Ujian::create($validated);

        return redirect()->route('ujian.show', $ujian)
            ->with('success', 'Ujian berhasil dibuat! Silakan input nilai siswa.');
    }

    public function show(Ujian $ujian)
    {
        $ujian->load(['guru', 'kelas', 'mataPelajaran', 'kategori', 'nilais.siswa']);
        
        // Get all students in this class for comparison
        $siswaKelas = Siswa::where('kelas_id', $ujian->kelas_id)->orderBy('nama')->get();
        
        // Calculate stats
        $nilaiStats = [
            'count' => $ujian->nilais->count(),
            'total' => $siswaKelas->count(),
            'avg' => $ujian->nilais->avg('nilai') ?? 0,
            'max' => $ujian->nilais->max('nilai') ?? 0,
            'min' => $ujian->nilais->min('nilai') ?? 0,
        ];

        return view('ujian.show', compact('ujian', 'siswaKelas', 'nilaiStats'));
    }

    public function edit(Ujian $ujian)
    {
        $kelass = Kelas::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama_mp')->get();
        $kategoris = UjianKategori::orderBy('nama_kategori')->get();

        return view('ujian.edit', compact('ujian', 'kelass', 'gurus', 'mapels', 'kategoris'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'kategori_id' => 'nullable|exists:ujian_kategoris,id',
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nama_ujian' => 'required|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $ujian->update($validated);

        return redirect()->route('ujian.show', $ujian)
            ->with('success', 'Data ujian berhasil diperbarui!');
    }

    public function destroy(Ujian $ujian)
    {
        $ujian->delete(); // Nilais cascade deleted

        return redirect()->route('ujian.index')
            ->with('success', 'Ujian dan nilai terkait berhasil dihapus!');
    }

    /**
     * Show form for inputting grades for all students in this exam
     */
    public function inputNilai(Ujian $ujian)
    {
        $ujian->load(['kelas', 'mataPelajaran', 'guru', 'kategori']);
        
        // Get all students in this class
        $siswaList = Siswa::where('kelas_id', $ujian->kelas_id)
            ->orderBy('nama')
            ->get();

        // Get existing grades indexed by siswa_id
        $existingNilai = $ujian->nilais->keyBy('siswa_id');

        return view('ujian.input_nilai', compact('ujian', 'siswaList', 'existingNilai'));
    }

    /**
     * Store grades for all students
     */
    public function storeNilai(Request $request, Ujian $ujian)
    {
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'array',
            'catatan.*' => 'nullable|string|max:255',
        ]);

        foreach ($request->nilai as $siswaId => $nilaiValue) {
            if ($nilaiValue !== null && $nilaiValue !== '') {
                Nilai::updateOrCreate(
                    [
                        'ujian_id' => $ujian->id,
                        'siswa_id' => $siswaId,
                    ],
                    [
                        'nilai' => $nilaiValue,
                        'catatan' => $request->catatan[$siswaId] ?? null,
                        'sekolah_id' => session('sekolah_id'),
                    ]
                );
            }
        }

        return redirect()->route('ujian.show', $ujian)
            ->with('success', 'Nilai siswa berhasil disimpan!');
    }
    public function exportNilai(Ujian $ujian)
    {
        try {
            $ujian->load(['kelas.siswas', 'mataPelajaran', 'guru', 'kategori', 'nilais']);
            
            $siswaKelas = $ujian->kelas->siswas()->orderBy('nama')->get();
            $nilaiMap = $ujian->nilais->keyBy('siswa_id');
            
            $data = $siswaKelas->map(function($siswa) use ($nilaiMap) {
                $nilaiSiswa = $nilaiMap->get($siswa->id);
                return [
                    'No' => null, // Will be filled by client or just index
                    'NIS' => $siswa->nis,
                    'Nama Siswa' => $siswa->nama,
                    'Nilai' => $nilaiSiswa ? $nilaiSiswa->nilai : '-',
                    'Catatan' => $nilaiSiswa ? ($nilaiSiswa->catatan ?? '-') : '-',
                ];
            });
            
            // Prepare exam info for header
            $examInfo = [
                'Nama Ujian' => $ujian->nama_ujian,
                'Kategori' => $ujian->kategori?->nama_kategori ?? '-',
                'Mata Pelajaran' => $ujian->mataPelajaran?->nama_mp ?? '-',
                'Kelas' => $ujian->kelas?->nama ?? '-',
                'Guru' => $ujian->guru?->nama ?? '-',
                'Tanggal' => $ujian->tanggal ? $ujian->tanggal->format('d F Y') : '-',
                'KKM' => '75', // Example, or fetch if exists
            ];
            
            return response()->json([
                'school' => session('sekolah_nama', 'SiIntel'),
                'exam_info' => $examInfo,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Export Nilai Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
        }
    }
}
