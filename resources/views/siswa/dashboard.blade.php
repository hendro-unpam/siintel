@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="row g-4">
    {{-- Welcome Card --}}
    <div class="col-12">
        <div class="table-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    @php
                        $siswa = \App\Models\Siswa::find(session('siswa_id'));
                    @endphp
                    
                    <div class="me-3">
                        @if($siswa && $siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto" class="user-avatar-lg">
                        @else
                            <div class="user-avatar-lg">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="mb-1">Selamat Datang, {{ session('user_name') }}!</h4>
                        <p class="text-muted mb-0">
                            NIS: <strong>{{ $siswa->nis ?? '-' }}</strong> | 
                            Kelas: <strong>{{ $siswa->kelas->nama ?? '-' }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance Summary --}}
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="card-body p-4">
                @php
                    $totalMasuk = $siswa ? $siswa->absens()->where('ket', 'M')->count() : 0;
                @endphp
                <div class="stat-icon bg-success mb-2">
                    <i class="fas fa-check"></i>
                </div>
                <h3 class="mb-1">{{ $totalMasuk }}</h3>
                <small class="text-muted">Hadir</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="card-body p-4">
                @php
                    $totalSakit = $siswa ? $siswa->absens()->where('ket', 'S')->count() : 0;
                @endphp
                <div class="stat-icon bg-warning mb-2">
                    <i class="fas fa-briefcase-medical"></i>
                </div>
                <h3 class="mb-1">{{ $totalSakit }}</h3>
                <small class="text-muted">Sakit</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="card-body p-4">
                @php
                    $totalIzin = $siswa ? $siswa->absens()->where('ket', 'I')->count() : 0;
                @endphp
                <div class="stat-icon bg-info mb-2">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3 class="mb-1">{{ $totalIzin }}</h3>
                <small class="text-muted">Izin</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="card-body p-4">
                @php
                    $totalAlpa = $siswa ? $siswa->absens()->where('ket', 'A')->count() : 0;
                @endphp
                <div class="stat-icon bg-danger mb-2">
                    <i class="fas fa-times"></i>
                </div>
                <h3 class="mb-1">{{ $totalAlpa }}</h3>
                <small class="text-muted">Alpa</small>
            </div>
        </div>
    </div>

    {{-- Recent Attendance --}}
    <div class="col-12">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Absensi Terakhir</h5>
            </div>
            <div class="card-body p-4">
                @php
                    $recentAbsens = $siswa ? $siswa->absens()->with(['jadwal.hari', 'jadwal.mataPelajaran'])
                        ->orderByDesc('tgl')
                        ->take(10)
                        ->get() : collect();
                @endphp

                @if($recentAbsens->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAbsens as $absen)
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada data absensi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .user-avatar-lg {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        object-fit: cover;
    }
    
    img.user-avatar-lg {
        background: none;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }
</style>
@endpush
