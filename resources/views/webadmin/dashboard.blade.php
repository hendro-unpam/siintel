@extends('layouts.web-admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Web Admin')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['berita'] }}</div>
                    <div class="stat-label">Total Berita</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
            <a href="{{ route('webadmin.berita.index') }}" class="btn btn-sm btn-link text-success p-0 mt-3">
                Kelola Berita <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['prestasi'] }}</div>
                    <div class="stat-label">Total Prestasi</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
            <a href="{{ route('webadmin.prestasi.index') }}" class="btn btn-sm btn-link text-success p-0 mt-3">
                Kelola Prestasi <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['ekstrakurikuler'] }}</div>
                    <div class="stat-label">Total Ekstrakurikuler</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-futbol"></i>
                </div>
            </div>
            <a href="{{ route('webadmin.ekstrakurikuler.index') }}" class="btn btn-sm btn-link text-warning p-0 mt-3">
                Kelola Ekskul <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Recent Content -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h5>
                <a href="{{ route('webadmin.berita.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBerita as $berita)
                            <tr>
                                <td>{{ Str::limit($berita->judul, 40) }}</td>
                                <td>{{ $berita->tanggal_post->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada berita
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Prestasi Terbaru</h5>
                <a href="{{ route('webadmin.prestasi.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPrestasi as $prestasi)
                            <tr>
                                <td>{{ Str::limit($prestasi->judul, 30) }}</td>
                                <td>{{ $prestasi->nama_siswa }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada prestasi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
