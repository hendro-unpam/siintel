<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MultiAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\PekerjaanController;

// Auth Routes (Multi-Role) - TANPA middleware
Route::get('/login', [MultiAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MultiAuthController::class, 'login']);
Route::post('/logout', [MultiAuthController::class, 'logout'])->name('logout');

// Public Frontend Routes
Route::get('/', [\App\Http\Controllers\FrontendController::class, 'index'])->name('home');
Route::get('/tentang', [\App\Http\Controllers\FrontendController::class, 'tentang'])->name('tentang');
Route::get('/berita', [\App\Http\Controllers\FrontendController::class, 'berita'])->name('frontend.berita');
Route::get('/berita/{berita}', [\App\Http\Controllers\FrontendController::class, 'detailBerita'])->name('frontend.berita.detail');
Route::get('/prestasi', [\App\Http\Controllers\FrontendController::class, 'prestasi'])->name('frontend.prestasi');
Route::get('/ekstrakurikuler', [\App\Http\Controllers\FrontendController::class, 'ekstrakurikuler'])->name('frontend.ekstrakurikuler');
Route::get('/hubungi', [\App\Http\Controllers\FrontendController::class, 'hubungi'])->name('hubungi');

// API Route for fetching siswa by kelas
Route::get('/api/kelas/{kelas}/siswa', function ($kelasId) {
    $siswa = \App\Models\Siswa::withoutGlobalScope('sekolah')
        ->where('kelas_id', $kelasId)
        ->orderBy('nama')
        ->get(['id', 'nama', 'nis']);
    return response()->json($siswa);
});

// Protected Routes - Guru (HARUS SEBELUM resource guru)
Route::middleware(['multi.auth', 'role:guru'])->prefix('guru-panel')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');
    
    // Guru can input absensi
    Route::get('/absen/input', [AbsenController::class, 'inputAbsen'])->name('absen.input');
    Route::get('/absen/siswa-by-jadwal', [AbsenController::class, 'getSiswaByJadwal'])->name('absen.siswa-by-jadwal');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
    
    // Guru can view jadwal
    Route::get('/jadwal', [JadwalController::class, 'guruJadwal'])->name('jadwal');
});

// Protected Routes - Siswa
Route::middleware(['multi.auth', 'role:siswa'])->prefix('siswa-panel')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');
    
    // Siswa can view their attendance
    Route::get('/absensi', function () {
        return view('siswa.absensi');
    })->name('absensi');
});

// Protected Routes - Admin Only
Route::middleware(['multi.auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Routes (Admin Only)
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mapel', MataPelajaranController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('sekolah', SekolahController::class);
    Route::resource('pekerjaan', PekerjaanController::class);
    
    // Absensi Routes (Admin)
    Route::get('/absen/input', [AbsenController::class, 'inputAbsen'])->name('absen.input');
    Route::get('/absen/export', [AbsenController::class, 'exportExcel'])->name('absen.export');
    Route::get('/absen/siswa-by-jadwal', [AbsenController::class, 'getSiswaByJadwal'])->name('absen.siswa-by-jadwal');
    Route::resource('absen', AbsenController::class);

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/absensi', [LaporanController::class, 'absensiPerKelas'])->name('laporan.absensi');
    Route::get('/laporan/rekap', [LaporanController::class, 'rekapBulanan'])->name('laporan.rekap');

    // Ujian & Nilai Routes
    Route::resource('ujian', \App\Http\Controllers\UjianController::class);
    Route::resource('ujian-kategori', \App\Http\Controllers\UjianKategoriController::class)->except(['show']);
    Route::get('/ujian/{ujian}/nilai', [\App\Http\Controllers\UjianController::class, 'inputNilai'])->name('ujian.input-nilai');
    Route::post('/ujian/{ujian}/nilai', [\App\Http\Controllers\UjianController::class, 'storeNilai'])->name('ujian.store-nilai');
    Route::get('/ujian/{ujian}/export', [\App\Http\Controllers\UjianController::class, 'exportNilai'])->name('ujian.export');

    // Public Content Management moved to Web Admin routes (line 95+)
    // Route::resource('berita', ...) - use webadmin.berita instead
    // Route::resource('prestasi', ...) - use webadmin.prestasi instead
    // Route::resource('ekstrakurikuler', ...) - use webadmin.ekstrakurikuler instead
});

// Web Admin Routes (for website content management)
Route::middleware(['multi.auth', 'role:admin'])->prefix('web-admin')->name('webadmin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\WebAdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('berita', \App\Http\Controllers\BeritaController::class)->parameters(['berita' => 'berita']);
    Route::resource('prestasi', \App\Http\Controllers\PrestasiController::class)->parameters(['prestasi' => 'prestasi']);
    Route::resource('ekstrakurikuler', \App\Http\Controllers\EkstrakurikulerController::class)->parameters(['ekstrakurikuler' => 'ekstrakurikuler']);
});

// Siswa: View Nilai
Route::middleware(['multi.auth', 'role:siswa'])->group(function () {
    Route::get('/siswa-panel/nilai', [\App\Http\Controllers\NilaiController::class, 'siswaIndex'])->name('siswa.nilai');
});
