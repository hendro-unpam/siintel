<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Hari;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $haris = Hari::all();
        $jadwals = Jadwal::with(['hari', 'guru', 'kelas', 'mataPelajaran'])
            ->orderBy('hari_id')
            ->orderBy('jam_mulai')
            ->get();
        
        $selectedHari = $request->get('hari_id', $haris->first()->id ?? 1);
        $kelass = Kelas::orderBy('nama')->get();

        return view('jadwal.index', compact('jadwals', 'haris', 'selectedHari', 'kelass'));
    }

    public function create()
    {
        $haris = Hari::all();
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $mapels = MataPelajaran::all();
        return view('jadwal.create', compact('haris', 'gurus', 'kelas', 'mapels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari_id' => 'required|exists:haris,id',
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['hari', 'guru', 'kelas', 'mataPelajaran']);
        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        $haris = Hari::all();
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $mapels = MataPelajaran::all();
        return view('jadwal.edit', compact('jadwal', 'haris', 'gurus', 'kelas', 'mapels'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'hari_id' => 'required|exists:haris,id',
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        $jadwal->update($validated);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    /**
     * Display jadwal for guru
     */
    public function guruJadwal()
    {
        $guruId = session('guru_id');
        $haris = Hari::all();
        $jadwals = Jadwal::with(['hari', 'kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->orderBy('hari_id')
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.jadwal', compact('jadwals', 'haris'));
    }
}
