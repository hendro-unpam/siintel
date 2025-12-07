@extends('layouts.app')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Guru')

@push('styles')
<style>
    .schedule-calendar {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .schedule-calendar th {
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        color: white;
        text-align: center;
        padding: 0.75rem;
        font-weight: 600;
    }
    .schedule-calendar td {
        vertical-align: top;
        padding: 0.5rem;
        min-height: 80px;
        border: 1px solid #e5e7eb;
    }
    .schedule-item {
        background: linear-gradient(135deg, #ddd6fe, #c4b5fd);
        border-left: 3px solid #7c3aed;
        border-radius: 0.375rem;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
    }
    .schedule-item .time {
        font-weight: 600;
        color: #5b21b6;
    }
    .schedule-item .mapel {
        color: #1f2937;
        font-weight: 500;
    }
    .schedule-item .kelas {
        color: #6b7280;
        font-size: 0.75rem;
    }
    .day-sunday {
        background-color: #fef2f2;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="table-card text-center">
            <div class="card-body">
                <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($guru->nama, 0, 1)) }}
                </div>
                <h4>{{ $guru->nama }}</h4>
                <p class="text-muted">NIP: {{ $guru->nip }}</p>
                <span class="badge {{ $guru->jk == 'L' ? 'bg-primary' : 'bg-pink' }}" style="{{ $guru->jk == 'P' ? 'background-color: #ec4899;' : '' }}">
                    {{ $guru->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
                <p class="mt-3 text-muted">{{ $guru->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Jadwal Mengajar</h5>
                {{-- View Toggle --}}
                <ul class="nav nav-pills nav-sm" id="viewTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active py-1 px-3" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button">
                            <i class="fas fa-list me-1"></i> List
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-1 px-3" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-view" type="button">
                            <i class="fas fa-calendar-alt me-1"></i> Kalender
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    {{-- LIST VIEW --}}
                    <div class="tab-pane fade show active" id="list-view" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead><tr><th>Hari</th><th>Jam</th><th>Kelas</th><th>Mata Pelajaran</th></tr></thead>
                                <tbody>
                                    @forelse($guru->jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->hari->hari ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                        <td>{{ $jadwal->kelas->nama ?? '-' }}</td>
                                        <td>{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada jadwal</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- CALENDAR VIEW --}}
                    <div class="tab-pane fade" id="calendar-view" role="tabpanel">
                        @php
                            // Group schedules by day
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                            $scheduleByDay = [];
                            foreach ($days as $day) {
                                $scheduleByDay[$day] = collect();
                            }
                            foreach ($guru->jadwals as $jadwal) {
                                $dayName = $jadwal->hari->hari ?? null;
                                if ($dayName && isset($scheduleByDay[$dayName])) {
                                    $scheduleByDay[$dayName]->push($jadwal);
                                }
                            }
                            // Sort each day by time
                            foreach ($scheduleByDay as $day => $schedules) {
                                $scheduleByDay[$day] = $schedules->sortBy('jam_mulai');
                            }
                        @endphp
                        
                        <div class="table-responsive">
                            <table class="table schedule-calendar mb-0">
                                <thead>
                                    <tr>
                                        @foreach($days as $day)
                                        <th class="{{ $day == 'Minggu' ? 'bg-danger' : '' }}" style="width: 14.28%;">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach($days as $day)
                                        <td class="{{ $day == 'Minggu' ? 'day-sunday' : '' }}">
                                            @forelse($scheduleByDay[$day] as $jadwal)
                                            <div class="schedule-item">
                                                <div class="time">
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </div>
                                                <div class="mapel">{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</div>
                                                <div class="kelas"><i class="fas fa-users me-1"></i>{{ $jadwal->kelas->nama ?? '-' }}</div>
                                            </div>
                                            @empty
                                            <div class="text-center text-muted py-3">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                            @endforelse
                                        </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Summary --}}
                        <div class="mt-3 text-center text-muted">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Total {{ $guru->jadwals->count() }} jadwal mengajar per minggu
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-4">
    <a href="{{ route('guru.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    <a href="{{ route('guru.edit', $guru) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i> Edit</a>
</div>
@endsection
