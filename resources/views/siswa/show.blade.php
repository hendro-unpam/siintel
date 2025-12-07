@extends('layouts.app')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('content')
<div class="table-card">
    <div class="card-body p-4">
        <div class="row g-4">
            {{-- Kolom 1: Profil dengan Foto --}}
            <div class="col-lg-3">
                <div class="text-center p-3 bg-light rounded">
                    <div class="foto-container mx-auto mb-3">
                        <img src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('images/default-avatar.png') }}" 
                             alt="Foto {{ $siswa->nama }}" 
                             class="foto-siswa">
                    </div>
                    <h5 class="mb-1">{{ $siswa->nama }}</h5>
                    <p class="text-muted small mb-2">NIS: {{ $siswa->nis }}</p>
                    <span class="badge {{ $siswa->jk == 'L' ? 'bg-primary' : 'bg-pink' }}">
                        {{ $siswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                    <div class="mt-2">
                        <span class="badge bg-secondary">{{ $siswa->kelas->nama ?? '-' }}</span>
                    </div>
                </div>
                
                <div class="mt-3 d-grid gap-2">
                    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Data
                    </a>
                    <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            {{-- Kolom 2: Informasi Detail --}}
            <div class="col-lg-9">
                <div class="row g-4">
                    {{-- Data Pribadi --}}
                    <div class="col-md-6">
                        <div class="section-box h-100">
                            <h6 class="section-title"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted" width="120">NIS</td>
                                    <td><strong>{{ $siswa->nis }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nama</td>
                                    <td><strong>{{ $siswa->nama }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis Kelamin</td>
                                    <td>{{ $siswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kelas</td>
                                    <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">No. Telepon</td>
                                    <td>{{ $siswa->tlp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Alamat</td>
                                    <td>{{ $siswa->alamat ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Data Orang Tua --}}
                    <div class="col-md-6">
                        <div class="section-box h-100">
                            <h6 class="section-title"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted" width="120">Nama Ayah</td>
                                    <td><strong>{{ $siswa->bapak ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Pekerjaan</td>
                                    <td>{{ $siswa->pekerjaanAyah->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nama Ibu</td>
                                    <td><strong>{{ $siswa->ibu ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Pekerjaan</td>
                                    <td>{{ $siswa->pekerjaanIbu->nama ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Riwayat Absensi --}}
                    <div class="col-12">
                        <div class="section-box">
                            <h6 class="section-title"><i class="fas fa-history me-2"></i>Riwayat Absensi Terakhir</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($siswa->absens->sortByDesc('tgl')->take(10) as $absen)
                                        <tr>
                                            <td>{{ $absen->tgl->format('d/m/Y') }}</td>
                                            <td>{{ $absen->jadwal->hari->hari ?? '-' }}</td>
                                            <td>{{ $absen->jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                            <td>
                                                @switch($absen->ket)
                                                    @case('M')<span class="badge bg-success">Masuk</span>@break
                                                    @case('S')<span class="badge bg-warning">Sakit</span>@break
                                                    @case('I')<span class="badge bg-info">Izin</span>@break
                                                    @case('A')<span class="badge bg-danger">Alpa</span>@break
                                                @endswitch
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                <i class="fas fa-clipboard-list me-1"></i> Belum ada data absensi
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
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-pink { background-color: #ec4899 !important; }
    .section-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
    }
    .section-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }
    .foto-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #e5e7eb;
    }
    .foto-siswa {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush
