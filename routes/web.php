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

// Home redirect
Route::get('/', function () {
    return redirect('/login');
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
});

// Siswa: View Nilai
Route::middleware(['multi.auth', 'role:siswa'])->group(function () {
    Route::get('/siswa-panel/nilai', [\App\Http\Controllers\NilaiController::class, 'siswaIndex'])->name('siswa.nilai');
});
