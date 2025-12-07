<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('tlp', 'like', "%{$search}%");
            });
        }

        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');
        $allowedSorts = ['nis', 'nama', 'jk', 'tlp', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('nama', 'asc');
        }

        $perPage = $request->get('per_page', 10);
        $siswas = $query->paginate($perPage)->withQueryString();

        return view('siswa.index', compact('siswas', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $pekerjaans = Pekerjaan::orderBy('nama')->get();
        return view('siswa.create', compact('kelas', 'pekerjaans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis|max:50',
            'nama' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kelas_id' => 'required|exists:kelas,id',
            'tlp' => 'nullable|max:20',
            'bapak' => 'nullable|max:50',
            'pekerjaan_ayah_id' => 'nullable|exists:pekerjaans,id',
            'ibu' => 'nullable|max:50',
            'pekerjaan_ibu_id' => 'nullable|exists:pekerjaans,id',
            'password' => 'required|min:6',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        
        Siswa::create($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'absens.jadwal.mataPelajaran', 'absens.jadwal.hari', 'pekerjaanAyah', 'pekerjaanIbu']);
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        $pekerjaans = Pekerjaan::orderBy('nama')->get();
        return view('siswa.edit', compact('siswa', 'kelas', 'pekerjaans'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|max:50|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kelas_id' => 'required|exists:kelas,id',
            'tlp' => 'nullable|max:20',
            'bapak' => 'nullable|max:50',
            'pekerjaan_ayah_id' => 'nullable|exists:pekerjaans,id',
            'ibu' => 'nullable|max:50',
            'pekerjaan_ibu_id' => 'nullable|exists:pekerjaans,id',
            'password' => 'nullable|min:6',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
