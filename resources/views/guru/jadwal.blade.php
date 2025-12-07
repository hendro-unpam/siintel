@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar')

@section('content')
<div class="table-card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar Saya
        </h5>
    </div>

    <div class="card-body p-4">
        {{-- Tab Hari --}}
        <ul class="nav nav-tabs" id="jadwalTab" role="tablist">
            @foreach ($haris as $index => $hari)
                <li class="nav-item" role="presentation">
                    <button 
                        class="nav-link {{ $index === 0 ? 'active' : '' }}"
                        id="hari{{ $hari->id }}-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#hari{{ $hari->id }}"
                        type="button"
                        role="tab"
                    >
                        {{ $hari->hari }}
                    </button>
                </li>
            @endforeach
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content mt-4" id="jadwalTabContent">
            @foreach ($haris as $index => $hari)
                @php
                    $jadwalHari = $jadwals->where('hari_id', $hari->id)->sortBy('jam_mulai');
                @endphp

                <div 
                    class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                    id="hari{{ $hari->id }}"
                    role="tabpanel"
                >
                    @if($jadwalHari->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Jam</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwalHari as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </td>
                                            <td>{{ $jadwal->kelas->nama ?? '-' }}</td>
                                            <td>{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('guru.absen.input') }}?jadwal={{ $jadwal->id }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-clipboard-check me-1"></i> Input Absen
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
                            <p class="mb-0">Tidak ada jadwal mengajar pada hari {{ $hari->hari }}.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #6b7280;
        border: 1px solid transparent;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
    }

    .nav-tabs .nav-link:hover {
        border-color: #e5e7eb #e5e7eb #dee2e6;
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        font-weight: 600;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }
</style>
@endpush
