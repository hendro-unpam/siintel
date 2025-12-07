<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\Ekstrakurikuler;

class WebAdminController extends Controller
{
    /**
     * Display Web Admin Dashboard
     */
    public function dashboard()
    {
        $stats = [
            'berita' => Berita::count(),
            'prestasi' => Prestasi::count(),
            'ekstrakurikuler' => Ekstrakurikuler::count(),
        ];

        $recentBerita = Berita::latest('tanggal_post')->take(5)->get();
        $recentPrestasi = Prestasi::latest('tanggal')->take(5)->get();

        return view('webadmin.dashboard', compact('stats', 'recentBerita', 'recentPrestasi'));
    }
}
