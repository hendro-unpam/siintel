@extends('layouts.app')

@section('title', 'Rekap Absensi Bulanan')
@section('page-title', 'Rekap Absensi Bulanan')

@section('content')
<div class="table-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Rekap Bulanan Semua Kelas</h5>
            <small class="text-muted">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</small>
        </div>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th class="text-center bg-success text-white">Masuk</th>
                        <th class="text-center bg-warning">Sakit</th>
                        <th class="text-center bg-info text-white">Izin</th>
                        <th class="text-center bg-danger text-white">Alpa</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $item)
                    <tr>
                        <td><strong>{{ $item->kelas_nama }}</strong></td>
                        <td class="text-center">{{ $item->masuk }}</td>
                        <td class="text-center">{{ $item->sakit }}</td>
                        <td class="text-center">{{ $item->izin }}</td>
                        <td class="text-center">{{ $item->alpa }}</td>
                        <td class="text-center"><strong>{{ $item->total }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data absensi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
