<?php

namespace App\Http\Controllers;

use App\Models\UjianKategori;
use Illuminate\Http\Request;

class UjianKategoriController extends Controller
{
    public function index()
    {
        $kategoris = UjianKategori::withCount('ujians')->orderBy('nama_kategori')->paginate(10);
        return view('ujian-kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('ujian-kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:50',
            'keterangan' => 'nullable|max:255',
        ]);

        UjianKategori::create($validated);

        return redirect()->route('ujian-kategori.index')
            ->with('success', 'Kategori ujian berhasil ditambahkan!');
    }

    public function edit(UjianKategori $ujian_kategori)
    {
        return view('ujian-kategori.edit', ['kategori' => $ujian_kategori]);
    }

    public function update(Request $request, UjianKategori $ujian_kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:50',
            'keterangan' => 'nullable|max:255',
        ]);

        $ujian_kategori->update($validated);

        return redirect()->route('ujian-kategori.index')
            ->with('success', 'Kategori ujian berhasil diperbarui!');
    }

    public function destroy(UjianKategori $ujian_kategori)
    {
        if ($ujian_kategori->ujians()->count() > 0) {
            return back()->with('error', 'Kategori ini masih digunakan oleh beberapa ujian!');
        }

        $ujian_kategori->delete();

        return redirect()->route('ujian-kategori.index')
            ->with('success', 'Kategori ujian berhasil dihapus!');
    }
}
