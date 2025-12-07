@extends('layouts.app')

@section('title', 'Laporan Absensi')
@section('page-title', 'Laporan Absensi')

@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="table-card h-100">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-users me-2"></i>Laporan Per Kelas</h5></div>
            <div class="card-body">
                <form action="{{ route('laporan.absensi') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <input type="month" name="bulan" class="form-control" value="{{ now()->format('Y-m') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-chart-bar me-1"></i> Lihat Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="table-card h-100">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Rekap Bulanan</h5></div>
            <div class="card-body">
                <form action="{{ route('laporan.rekap') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <input type="month" name="bulan" class="form-control" value="{{ now()->format('Y-m') }}" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-file-alt me-1"></i> Lihat Rekap
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
