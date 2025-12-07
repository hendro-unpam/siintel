<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');
        $allowedSorts = ['nip', 'nama', 'jk', 'alamat', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('nama', 'asc');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $gurus = $query->paginate($perPage)->withQueryString();

        return view('guru.index', compact('gurus', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|max:50',
            'nama' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        Guru::create($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show(Guru $guru)
    {
        $guru->load('jadwals.kelas', 'jadwals.mataPelajaran');
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nip' => 'required|max:50',
            'nama' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $guru->update($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus!');
    }
}
