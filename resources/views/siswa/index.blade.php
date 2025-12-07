@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Siswa</h5>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Siswa
            </a>
        </div>
        
        {{-- Search & Filter Bar --}}
        <div class="row g-2 mt-3">
            <div class="col-md-4">
                <form action="{{ route('siswa.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari NIS, nama, telepon..." value="{{ request('search') }}">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
                    @endif
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <form action="{{ route('siswa.index') }}" method="GET" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label class="form-label mb-0 small">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="small text-muted">dari {{ $siswas->total() }} data</span>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="60">Foto</th>
                        <th>
                            <a href="{{ route('siswa.index', array_merge(request()->all(), ['sort' => 'nis', 'direction' => $sortField == 'nis' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                NIS @if($sortField == 'nis')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('siswa.index', array_merge(request()->all(), ['sort' => 'nama', 'direction' => $sortField == 'nama' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Nama @if($sortField == 'nama')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('siswa.index', array_merge(request()->all(), ['sort' => 'jk', 'direction' => $sortField == 'jk' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                JK @if($sortField == 'jk')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>Kelas</th>
                        <th>Telepon</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $siswas->firstItem() + $index }}</td>
                        <td>
                            <img src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $siswa->nama }}" 
                                 class="foto-thumbnail">
                        </td>
                        <td><code>{{ $siswa->nis }}</code></td>
                        <td><strong>{{ $siswa->nama }}</strong></td>
                        <td>
                            <span class="badge {{ $siswa->jk == 'L' ? 'bg-primary' : 'bg-pink' }}">
                                {{ $siswa->jk == 'L' ? 'L' : 'P' }}
                            </span>
                        </td>
                        <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                        <td>{{ $siswa->tlp ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('siswa.show', $siswa) }}" class="btn btn-outline-info" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-users fa-2x mb-2"></i><br>
                            @if(request('search'))
                                Tidak ada hasil untuk "{{ request('search') }}"
                            @else
                                Belum ada data siswa
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($siswas->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan {{ $siswas->firstItem() }} - {{ $siswas->lastItem() }} dari {{ $siswas->total() }} data
        </small>
        {{ $siswas->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .bg-pink { background-color: #ec4899 !important; }
    th a:hover { color: var(--primary-color) !important; }
    
    .foto-thumbnail {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
</style>
@endpush
