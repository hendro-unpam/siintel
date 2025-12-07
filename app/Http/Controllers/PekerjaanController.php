<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pekerjaan::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['nama', 'keterangan', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = $request->get('per_page', 15);
        $pekerjaans = $query->paginate($perPage)->withQueryString();

        return view('pekerjaan.index', compact('pekerjaans', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        return view('pekerjaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:pekerjaans',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Pekerjaan::create($request->only(['nama', 'keterangan']));

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan!');
    }

    public function edit(Pekerjaan $pekerjaan)
    {
        return view('pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:pekerjaans,nama,' . $pekerjaan->id,
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pekerjaan->update($request->only(['nama', 'keterangan']));

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui!');
    }

    public function destroy(Pekerjaan $pekerjaan)
    {
        $pekerjaan->delete();
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus!');
    }
}
