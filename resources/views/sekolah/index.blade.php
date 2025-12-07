@extends('layouts.app')

@section('title', 'Data Sekolah')
@section('page-title', 'Data Sekolah')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-building me-2"></i>Daftar Sekolah</h5>
            <a href="{{ route('sekolah.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Sekolah
            </a>
        </div>
        
        <div class="row g-2 mt-3">
            <div class="col-md-4">
                <form action="{{ route('sekolah.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kode, nama, kepala sekolah..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('sekolah.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
                    @endif
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <form action="{{ route('sekolah.index') }}" method="GET" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label class="form-label mb-0 small">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                        @foreach([10, 25, 50] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="small text-muted">dari {{ $sekolahs->total() }} data</span>
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
                            <a href="{{ route('sekolah.index', array_merge(request()->all(), ['sort' => 'kode', 'direction' => $sortField == 'kode' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Kode @if($sortField == 'kode')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('sekolah.index', array_merge(request()->all(), ['sort' => 'nama', 'direction' => $sortField == 'nama' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Nama Sekolah @if($sortField == 'nama')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>Kepala Sekolah</th>
                        <th>Alamat</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sekolahs as $index => $sekolah)
                    <tr>
                        <td>{{ $sekolahs->firstItem() + $index }}</td>
                        <td><code>{{ $sekolah->kode }}</code></td>
                        <td><strong>{{ $sekolah->nama }}</strong></td>
                        <td>{{ $sekolah->kepala ?? '-' }}</td>
                        <td>{{ Str::limit($sekolah->alamat, 40) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('sekolah.show', $sekolah) }}" class="btn btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('sekolah.edit', $sekolah) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('sekolah.destroy', $sekolah) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($sekolahs->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $sekolahs->firstItem() }} - {{ $sekolahs->lastItem() }} dari {{ $sekolahs->total() }}</small>
        {{ $sekolahs->links() }}
    </div>
    @endif
</div>
@endsection
