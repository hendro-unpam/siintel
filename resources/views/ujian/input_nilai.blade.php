@extends('layouts.app')

@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-keyboard me-2"></i>Input Nilai: {{ $ujian->nama_ujian }}</h5>
            <span class="badge bg-white text-success">{{ $ujian->kelas->nama ?? '-' }} | {{ $ujian->mataPelajaran->nama_mp ?? '-' }}</span>
        </div>
    </div>

    <form action="{{ route('ujian.store-nilai', $ujian) }}" method="POST">
        @csrf
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="100">NIS</th>
                            <th>Nama Siswa</th>
                            <th width="120" class="text-center">Nilai (0-100)</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaList as $index => $siswa)
                        @php
                            $existing = $existingNilai->get($siswa->id);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><code>{{ $siswa->nis }}</code></td>
                            <td><strong>{{ $siswa->nama }}</strong></td>
                            <td>
                                <input type="number" 
                                       name="nilai[{{ $siswa->id }}]" 
                                       class="form-control form-control-sm text-center" 
                                       min="0" max="100" step="0.1"
                                       value="{{ old('nilai.'.$siswa->id, $existing->nilai ?? '') }}"
                                       placeholder="0-100">
                            </td>
                            <td>
                                <input type="text" 
                                       name="catatan[{{ $siswa->id }}]" 
                                       class="form-control form-control-sm" 
                                       value="{{ old('catatan.'.$siswa->id, $existing->catatan ?? '') }}"
                                       placeholder="Catatan (opsional)">
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada siswa di kelas ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('ujian.show', $ujian) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Simpan Semua Nilai
            </button>
        </div>
    </form>
</div>

<div class="alert alert-info mt-3">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Tips:</strong> Anda bisa menggunakan tombol <kbd>Tab</kbd> untuk berpindah ke kolom nilai berikutnya dengan cepat.
</div>
@endsection
