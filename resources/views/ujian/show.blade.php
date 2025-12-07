@extends('layouts.app')

@section('title', 'Detail Ujian')
@section('page-title', 'Detail Ujian')

@section('content')
<div class="row">
    {{-- Left: Ujian Info --}}
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>{{ $ujian->nama_ujian }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="120"><i class="fas fa-tags me-2"></i>Kategori</td>
                        <td><span class="badge bg-secondary">{{ $ujian->kategori->nama_kategori ?? 'Tidak ada' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted" width="120"><i class="fas fa-chalkboard me-2"></i>Kelas</td>
                        <td><strong>{{ $ujian->kelas->nama ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-book me-2"></i>Mapel</td>
                        <td>{{ $ujian->mataPelajaran->nama_mp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-user-tie me-2"></i>Guru</td>
                        <td>{{ $ujian->guru->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-calendar me-2"></i>Tanggal</td>
                        <td>{{ $ujian->tanggal->format('d F Y') }}</td>
                    </tr>
                    @if($ujian->keterangan)
                    <tr>
                        <td class="text-muted"><i class="fas fa-sticky-note me-2"></i>Keterangan</td>
                        <td>{{ $ujian->keterangan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="card-footer bg-white">
                <div class="d-grid gap-2">
                    <a href="{{ route('ujian.input-nilai', $ujian) }}" class="btn btn-success">
                        <i class="fas fa-keyboard me-2"></i>Input Nilai
                    </a>
                    <a href="{{ route('ujian.edit', $ujian) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit me-2"></i>Edit Ujian
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Nilai</h6>
            </div>
            <div class="card-body">
                <div class="row text-center g-2">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Sudah Dinilai</small>
                            <h4 class="mb-0 text-primary">{{ $nilaiStats['count'] }}/{{ $nilaiStats['total'] }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Rata-rata</small>
                            <h4 class="mb-0 text-success">{{ number_format($nilaiStats['avg'], 1) }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Tertinggi</small>
                            <h4 class="mb-0 text-info">{{ number_format($nilaiStats['max'], 1) }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Terendah</small>
                            <h4 class="mb-0 text-danger">{{ number_format($nilaiStats['min'], 1) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Nilai Table --}}
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list-ol me-2"></i>Daftar Nilai Siswa</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th width="100" class="text-center">Nilai</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nilaiMap = $ujian->nilais->keyBy('siswa_id');
                            @endphp
                            @forelse($siswaKelas as $index => $siswa)
                            @php
                                $nilaiSiswa = $nilaiMap->get($siswa->id);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $siswa->nis }}</code></td>
                                <td>{{ $siswa->nama }}</td>
                                <td class="text-center">
                                    @if($nilaiSiswa)
                                        <span class="badge {{ $nilaiSiswa->nilai >= 75 ? 'bg-success' : ($nilaiSiswa->nilai >= 60 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                            {{ number_format($nilaiSiswa->nilai, 1) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $nilaiSiswa->catatan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada siswa di kelas ini</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('ujian.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Ujian
    </a>
</div>
@endsection
