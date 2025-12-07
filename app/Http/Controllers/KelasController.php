<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with('sekolah')->withCount('siswas');

        // Search
        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        // Sort
        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');
        $allowedSorts = ['nama', 'siswas_count', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = $request->get('per_page', 10);
        $kelas = $query->paginate($perPage)->withQueryString();

        return view('kelas.index', compact('kelas', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        $sekolahs = Sekolah::all();
        return view('kelas.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nama' => 'required|max:50',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function show(Kelas $kela)
    {
        $kela->load('sekolah', 'siswas');
        return view('kelas.show', compact('kela'));
    }

    public function edit(Kelas $kela)
    {
        $sekolahs = Sekolah::all();
        return view('kelas.edit', compact('kela', 'sekolahs'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nama' => 'required|max:50',
        ]);

        $kela->update($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus!');
    }
}
