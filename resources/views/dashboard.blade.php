@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['siswa'] }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-link text-primary p-0 mt-3">
                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['guru'] }}</div>
                    <div class="stat-label">Total Guru</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <a href="{{ route('guru.index') }}" class="btn btn-sm btn-link text-success p-0 mt-3">
                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['kelas'] }}</div>
                    <div class="stat-label">Total Kelas</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-link text-warning p-0 mt-3">
                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['mapel'] }}</div>
                    <div class="stat-label">Mata Pelajaran</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
            <a href="{{ route('mapel.index') }}" class="btn btn-sm btn-link text-danger p-0 mt-3">
                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions & Info -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Absensi Terbaru</h5>
                <a href="{{ route('absen.input') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Input Absensi
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAbsen as $absen)
                            <tr>
                                <td>{{ $absen->tgl->format('d/m/Y') }}</td>
                                <td>{{ $absen->siswa?->nama ?? '-' }}</td>
                                <td>{{ $absen->jadwal?->mataPelajaran?->nama_mp ?? '-' }}</td>
                                <td>
                                    @switch($absen->ket)
                                        @case('M')
                                            <span class="badge bg-success">Masuk</span>
                                            @break
                                        @case('S')
                                            <span class="badge bg-warning">Sakit</span>
                                            @break
                                        @case('I')
                                            <span class="badge bg-info">Izin</span>
                                            @break
                                        @case('A')
                                            <span class="badge bg-danger">Alpa</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada data absensi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #1e1b4b, #312e81); color: #fff;">
            <div class="mb-3">
                <i class="fas fa-info-circle fa-2x" style="color: #818cf8;"></i>
            </div>
            <h5 class="mb-3">Selamat Datang!</h5>
            <p class="mb-3" style="color: #c7d2fe;">
                Sistem Informasi Sekolah (SiIntel) membantu Anda mengelola data akademik sekolah dengan mudah.
            </p>
            <ul class="list-unstyled mb-0" style="color: #c7d2fe; font-size: 0.875rem;">
                <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: #34d399;"></i> Kelola Data Siswa & Guru</li>
                <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: #34d399;"></i> Atur Jadwal Pelajaran</li>
                <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: #34d399;"></i> Input Absensi Harian</li>
                <li><i class="fas fa-check-circle me-2" style="color: #34d399;"></i> Laporan Absensi</li>
            </ul>
        </div>
    </div>
</div>
@endsection
