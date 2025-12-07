@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('content')
<div class="row g-4">
    {{-- Welcome Card --}}
    <div class="col-12">
        <div class="table-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="user-avatar-lg me-3">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Selamat Datang, {{ session('user_name') }}!</h4>
                        <p class="text-muted mb-0">Anda login sebagai <strong>Guru</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-md-6">
        <div class="table-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Input Absensi</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-3">Input absensi siswa sesuai jadwal mengajar Anda.</p>
                <a href="{{ route('guru.absen.input') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Input Absensi
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="table-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-3">Lihat jadwal mengajar Anda minggu ini.</p>
                <a href="{{ route('guru.jadwal') }}" class="btn btn-info">
                    <i class="fas fa-eye me-1"></i> Lihat Jadwal
                </a>
            </div>
        </div>
    </div>

    {{-- Today's Schedule --}}
    <div class="col-12">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Jadwal Hari Ini</h5>
            </div>
            <div class="card-body p-4">
                @php
                    $hariIni = \App\Models\Hari::where('hari', \Carbon\Carbon::now()->locale('id')->dayName)->first();
                    $jadwalHariIni = $hariIni ? \App\Models\Jadwal::with(['kelas', 'mataPelajaran'])
                        ->where('guru_id', session('guru_id'))
                        ->where('hari_id', $hariIni->id)
                        ->orderBy('jam_mulai')
                        ->get() : collect();
                @endphp

                @if($jadwalHariIni->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Jam</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwalHariIni as $jadwal)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                    <td>{{ $jadwal->kelas->nama ?? '-' }}</td>
                                    <td>{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('guru.absen.input') }}?jadwal={{ $jadwal->id }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-clipboard-check me-1"></i> Absen
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-coffee fa-2x mb-2"></i>
                        <p class="mb-0">Tidak ada jadwal mengajar hari ini.</p>
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
    }
</style>
@endpush
