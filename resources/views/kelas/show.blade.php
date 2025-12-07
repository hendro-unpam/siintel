@extends('layouts.app')

@section('title', 'Detail Kelas')
@section('page-title', 'Detail Kelas ' . $kela->nama)

@section('content')
<div class="table-card mb-4">
    <div class="card-header"><h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Siswa Kelas {{ $kela->nama }}</h5></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>No</th><th>NIS</th><th>Nama</th><th>L/P</th><th>Telepon</th></tr></thead>
                <tbody>
                    @forelse($kela->siswas as $index => $siswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><code>{{ $siswa->nis }}</code></td>
                        <td><a href="{{ route('siswa.show', $siswa) }}">{{ $siswa->nama }}</a></td>
                        <td>{{ $siswa->jk }}</td>
                        <td>{{ $siswa->tlp ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-3 text-muted">Belum ada siswa di kelas ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<a href="{{ route('kelas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
@endsection
