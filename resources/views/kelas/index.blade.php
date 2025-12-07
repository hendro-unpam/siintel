@extends('layouts.app')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-school me-2"></i>Daftar Kelas</h5>
            <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Kelas
            </a>
        </div>
        
        <div class="row g-2 mt-3">
            <div class="col-md-4">
                <form action="{{ route('kelas.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama kelas..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
                    @endif
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <form action="{{ route('kelas.index') }}" method="GET" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label class="form-label mb-0 small">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="small text-muted">dari {{ $kelas->total() }} data</span>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>
                            <a href="{{ route('kelas.index', array_merge(request()->all(), ['sort' => 'nama', 'direction' => $sortField == 'nama' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Nama Kelas @if($sortField == 'nama')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>Sekolah</th>
                        <th>
                            <a href="{{ route('kelas.index', array_merge(request()->all(), ['sort' => 'siswas_count', 'direction' => $sortField == 'siswas_count' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Jumlah Siswa @if($sortField == 'siswas_count')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $index => $k)
                    <tr>
                        <td>{{ $kelas->firstItem() + $index }}</td>
                        <td><strong>{{ $k->nama }}</strong></td>
                        <td>{{ $k->sekolah->nama ?? '-' }}</td>
                        <td><span class="badge bg-primary">{{ $k->siswas_count }} siswa</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('kelas.show', $k) }}" class="btn btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('kelas.edit', $k) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('kelas.destroy', $k) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($kelas->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $kelas->firstItem() }} - {{ $kelas->lastItem() }} dari {{ $kelas->total() }}</small>
        {{ $kelas->links() }}
    </div>
    @endif
</div>
@endsection
