@extends('layouts.app')

@section('title', 'Riwayat Absensi')
@section('page-title', 'Riwayat Absensi')

@section('content')
<div class="table-card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Riwayat Absensi Saya
        </h5>
    </div>

    <div class="card-body p-4">
        @php
            $siswa = \App\Models\Siswa::with(['kelas'])->find(session('siswa_id'));
            $absens = $siswa ? $siswa->absens()
                ->with(['jadwal.hari', 'jadwal.mataPelajaran', 'jadwal.guru'])
                ->orderByDesc('tgl')
                ->paginate(20) : collect();
        @endphp

        @if($siswa)
            <div class="row mb-4">
                <div class="col-md-6">
                    <small class="text-muted">Nama Siswa</small>
                    <p class="mb-0 fw-bold">{{ $siswa->nama }}</p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">NIS</small>
                    <p class="mb-0 fw-bold">{{ $siswa->nis }}</p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Kelas</small>
                    <p class="mb-0 fw-bold">{{ $siswa->kelas->nama ?? '-' }}</p>
                </div>
            </div>

            <hr class="mb-4">
        @endif

        @if($absens->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absens as $absen)
                            <tr>
                                <td>{{ $loop->iteration + ($absens->currentPage() - 1) * $absens->perPage() }}</td>
                                <td>{{ $absen->tgl->format('d/m/Y') }}</td>
                                <td>{{ $absen->jadwal->hari->hari ?? '-' }}</td>
                                <td>{{ $absen->jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                <td>{{ $absen->jadwal->guru->nama ?? '-' }}</td>
                                <td>
                                    @switch($absen->ket)
                                        @case('M')<span class="badge bg-success">Masuk</span>@break
                                        @case('S')<span class="badge bg-warning">Sakit</span>@break
                                        @case('I')<span class="badge bg-info">Izin</span>@break
                                        @case('A')<span class="badge bg-danger">Alpa</span>@break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $absens->links() }}
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                <p class="mb-0">Belum ada data absensi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
