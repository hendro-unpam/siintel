<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasis = Prestasi::latest()->paginate(10);
        return view('prestasi.index', compact('prestasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahId = \Illuminate\Support\Facades\Session::get('sekolah_id');
        $kelas = \App\Models\Kelas::withoutGlobalScope('sekolah')
            ->where('sekolah_id', $sekolahId)
            ->orderBy('nama')->get();
        return view('prestasi.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:akademik,non_akademik',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('prestasi', 'public');
        }

        Prestasi::create($data);

        $routePrefix = request()->is('web-admin/*') ? 'webadmin.' : '';
        return redirect()->route($routePrefix . 'prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestasi $prestasi)
    {
        return view('prestasi.show', compact('prestasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestasi $prestasi)
    {
        $sekolahId = \Illuminate\Support\Facades\Session::get('sekolah_id');
        $kelas = \App\Models\Kelas::withoutGlobalScope('sekolah')
            ->where('sekolah_id', $sekolahId)
            ->orderBy('nama')->get();
        return view('prestasi.edit', compact('prestasi', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:akademik,non_akademik',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($prestasi->gambar) {
                Storage::disk('public')->delete($prestasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        $routePrefix = request()->is('web-admin/*') ? 'webadmin.' : '';
        return redirect()->route($routePrefix . 'prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->gambar) {
            Storage::disk('public')->delete($prestasi->gambar);
        }
        
        $prestasi->delete();

        $routePrefix = request()->is('web-admin/*') ? 'webadmin.' : '';
        return redirect()->route($routePrefix . 'prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
