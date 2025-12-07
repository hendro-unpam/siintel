<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::query();

        if ($request->filled('search')) {
            $query->where('nama_mp', 'like', "%{$request->search}%");
        }

        $sortField = $request->get('sort', 'nama_mp');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['nama_mp', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = $request->get('per_page', 10);
        $mapels = $query->paginate($perPage)->withQueryString();

        return view('mapel.index', compact('mapels', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mp' => 'required|max:100',
        ]);

        MataPelajaran::create($validated);

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function show(MataPelajaran $mapel)
    {
        return view('mapel.show', compact('mapel'));
    }

    public function edit(MataPelajaran $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $validated = $request->validate([
            'nama_mp' => 'required|max:100',
        ]);

        $mapel->update($validated);

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroy(MataPelajaran $mapel)
    {
        $mapel->delete();

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
