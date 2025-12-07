<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\Ekstrakurikuler;

class FrontendController extends Controller
{
    public function index()
    {
        // Logic to determine school based on domain/subdomain can be added here
        // For now, we fetch all or filter by a default school if needed
        
        $beritas = Berita::latest('tanggal_post')->take(3)->get();
        $prestasis = Prestasi::latest('tanggal')->take(3)->get();
        
        return view('frontend.home', compact('beritas', 'prestasis'));
    }

    public function tentang()
    {
        return view('frontend.tentang');
    }

    public function berita(Request $request)
    {
        // Show all berita from all schools (bypass sekolah scope for public page)
        $query = Berita::withoutGlobalScope('sekolah')
            ->with('sekolah');
        
        // Filter by sekolah if specified
        $sekolahId = $request->query('sekolah');
        $sekolah = null;
        if ($sekolahId) {
            $query->where('sekolah_id', $sekolahId);
            $sekolah = \App\Models\Sekolah::find($sekolahId);
        }
        
        $beritas = $query->latest('tanggal_post')->paginate(9);
        
        // Append query string to pagination links
        if ($sekolahId) {
            $beritas->appends(['sekolah' => $sekolahId]);
        }
        
        return view('frontend.berita', compact('beritas', 'sekolah'));
    }

    public function detailBerita($id, Request $request)
    {
        // Bypass sekolah scope to allow viewing berita from any school
        $berita = Berita::withoutGlobalScope('sekolah')
            ->with('sekolah')
            ->findOrFail($id);
        
        $berita->increment('views');
        
        // Get latest berita for sidebar
        $query = Berita::withoutGlobalScope('sekolah')
            ->with('sekolah')
            ->where('id', '!=', $id);
        
        // If filter=sekolah parameter, only show same school berita
        $filterSekolah = $request->query('filter') === 'sekolah';
        if ($filterSekolah) {
            $query->where('sekolah_id', $berita->sekolah_id);
        }
        
        $latestBerita = $query->latest('tanggal_post')->take(5)->get();
        
        return view('frontend.detail_berita', compact('berita', 'latestBerita', 'filterSekolah'));
    }

    public function prestasi(Request $request)
    {
        // Bypass sekolah scope for public page
        $query = Prestasi::withoutGlobalScope('sekolah')
            ->with('sekolah')
            ->latest('tanggal');
        
        // Filter by kategori if specified
        if ($request->has('kategori') && in_array($request->kategori, ['akademik', 'non_akademik'])) {
            $query->where('kategori', $request->kategori);
        }
        
        // Filter by sekolah if specified
        $sekolahId = $request->query('sekolah');
        $sekolah = null;
        if ($sekolahId) {
            $query->where('sekolah_id', $sekolahId);
            $sekolah = \App\Models\Sekolah::find($sekolahId);
        }
        
        $prestasis = $query->paginate(9);
        
        // Append query strings to pagination
        $prestasis->appends($request->only(['kategori', 'sekolah']));
        
        return view('frontend.prestasi', compact('prestasis', 'sekolah'));
    }

    public function ekstrakurikuler()
    {
        // Bypass sekolah scope for public page
        $ekstrakurikulers = Ekstrakurikuler::withoutGlobalScope('sekolah')
            ->with('sekolah')
            ->get();
        return view('frontend.ekstrakurikuler', compact('ekstrakurikulers'));
    }

    public function hubungi()
    {
        return view('frontend.hubungi');
    }
}
