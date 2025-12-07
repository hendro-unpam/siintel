<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        // If user is admin of a specific school, redirect to their school detail
        if (session('sekolah_id')) {
            $sekolah = Sekolah::find(session('sekolah_id'));
            if ($sekolah) {
                return redirect()->route('sekolah.show', $sekolah);
            }
        }

        $query = Sekolah::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('kepala', 'like', "%{$search}%")
                  ->orWhere('nip_kepsek', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['kode', 'nama', 'kepala', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = $request->get('per_page', 10);
        $sekolahs = $query->paginate($perPage)->withQueryString();

        return view('sekolah.index', compact('sekolahs', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        return view('sekolah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|max:50',
            'nama' => 'required|max:100',
            'alamat' => 'required',
            'kepala' => 'nullable|max:100',
            'nip_kepsek' => 'nullable|max:50',
            'logo' => 'nullable|image|max:2048',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('sekolah', 'public');
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('sekolah', 'public');
        }

        Sekolah::create($validated);

        return redirect()->route('sekolah.index')
            ->with('success', 'Data sekolah berhasil ditambahkan!');
    }

    public function show(Sekolah $sekolah)
    {
        $sekolah->loadCount(['gurus', 'siswas', 'kelas']);
        return view('sekolah.show', compact('sekolah'));
    }

    public function edit(Sekolah $sekolah)
    {
        return view('sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $validated = $request->validate([
            'kode' => 'required|max:50',
            'nama' => 'required|max:100',
            'alamat' => 'required',
            'kepala' => 'nullable|max:100',
            'nip_kepsek' => 'nullable|max:50',
            'logo' => 'nullable|image|max:2048',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($sekolah->logo) {
                Storage::disk('public')->delete($sekolah->logo);
            }
            $validated['logo'] = $request->file('logo')->store('sekolah', 'public');
        }

        if ($request->hasFile('gambar')) {
            if ($sekolah->gambar) {
                Storage::disk('public')->delete($sekolah->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('sekolah', 'public');
        }

        $sekolah->update($validated);

        return redirect()->route('sekolah.index')
            ->with('success', 'Data sekolah berhasil diperbarui!');
    }

    public function destroy(Sekolah $sekolah)
    {
        if ($sekolah->logo) {
            Storage::disk('public')->delete($sekolah->logo);
        }
        if ($sekolah->gambar) {
            Storage::disk('public')->delete($sekolah->gambar);
        }

        $sekolah->delete();

        return redirect()->route('sekolah.index')
            ->with('success', 'Data sekolah berhasil dihapus!');
    }
}
