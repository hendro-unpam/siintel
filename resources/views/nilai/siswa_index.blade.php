@extends('layouts.app')

@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Saya')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Daftar Nilai Ujian</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Tanggal</th>
                        <th width="100" class="text-center">Nilai</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais as $index => $nilai)
                    <tr>
                        <td>{{ $nilais->firstItem() + $index }}</td>
                        <td><strong>{{ $nilai->ujian->nama_ujian ?? '-' }}</strong></td>
                        <td>{{ $nilai->ujian->mataPelajaran->nama_mp ?? '-' }}</td>
                        <td>{{ $nilai->ujian->guru->nama ?? '-' }}</td>
                        <td>{{ $nilai->ujian->tanggal?->format('d M Y') ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $nilai->nilai >= 75 ? 'bg-success' : ($nilai->nilai >= 60 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                {{ number_format($nilai->nilai, 1) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $nilai->catatan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Belum ada nilai yang diinput
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($nilais->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $nilais->firstItem() }} - {{ $nilais->lastItem() }} dari {{ $nilais->total() }}</small>
        {{ $nilais->links() }}
    </div>
    @endif
</div>
@endsection
