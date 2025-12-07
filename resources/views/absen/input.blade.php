@extends('layouts.app')

@section('title', 'Input Absensi')
@section('page-title', 'Input Absensi')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="table-card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-filter me-2"></i>Pilih Jadwal</h5></div>
            <div class="card-body">
                <form action="{{ route('absen.input') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tgl" class="form-control" value="{{ $tgl }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jadwal Pelajaran</label>
                        <select name="jadwal_id" class="form-select" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach($jadwals as $jadwal)
                                @if($jadwal->kelas && $jadwal->mataPelajaran)
                                <option value="{{ $jadwal->id }}" {{ $selectedJadwal && $selectedJadwal->id == $jadwal->id ? 'selected' : '' }}>
                                    {{ $jadwal->hari->hari ?? '-' }} - {{ $jadwal->kelas->nama ?? '-' }} - {{ $jadwal->mataPelajaran->nama_mp ?? '-' }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Tampilkan Siswa
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        @if($selectedJadwal && $siswas->count())
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Absensi {{ $selectedJadwal->kelas->nama }} - {{ $selectedJadwal->mataPelajaran->nama_mp }}
                </h5>
                <small class="text-muted">{{ \Carbon\Carbon::parse($tgl)->translatedFormat('l, d F Y') }}</small>
            </div>
            <div class="card-body p-0">
                <form action="{{ route('absen.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
                    <input type="hidden" name="tgl" value="{{ $tgl }}">
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th class="text-center">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $index => $siswa)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><code>{{ $siswa->nis }}</code></td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>
                                        <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $siswa->id }}">
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="absensi[{{ $index }}][ket]" id="m{{ $siswa->id }}" value="M" {{ $siswa->existing_ket == 'M' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="m{{ $siswa->id }}">Masuk</label>

                                            <input type="radio" class="btn-check" name="absensi[{{ $index }}][ket]" id="s{{ $siswa->id }}" value="S" {{ $siswa->existing_ket == 'S' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="s{{ $siswa->id }}">Sakit</label>

                                            <input type="radio" class="btn-check" name="absensi[{{ $index }}][ket]" id="i{{ $siswa->id }}" value="I" {{ $siswa->existing_ket == 'I' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info" for="i{{ $siswa->id }}">Izin</label>

                                            <input type="radio" class="btn-check" name="absensi[{{ $index }}][ket]" id="a{{ $siswa->id }}" value="A" {{ $siswa->existing_ket == 'A' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="a{{ $siswa->id }}">Alpa</label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Absensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @elseif($selectedJadwal)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Tidak ada siswa di kelas ini.
        </div>
        @else
        <div class="table-card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                <h5>Pilih Jadwal Terlebih Dahulu</h5>
                <p>Silakan pilih tanggal dan jadwal pelajaran untuk menginput absensi.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
