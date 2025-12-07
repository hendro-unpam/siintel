@extends('layouts.app')

@section('title', 'Mata Pelajaran')
@section('page-title', 'Mata Pelajaran')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Daftar Mata Pelajaran</h5>
                    <a href="{{ route('mapel.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </a>
                </div>
                
                <div class="row g-2 mt-3">
                    <div class="col-md-5">
                        <form action="{{ route('mapel.index') }}" method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari mata pelajaran..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                            @if(request('search'))
                                <a href="{{ route('mapel.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-7 text-md-end">
                        <form action="{{ route('mapel.index') }}" method="GET" class="d-inline-flex align-items-center gap-2">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <label class="form-label mb-0 small">Tampilkan:</label>
                            <select name="per_page" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                                @foreach([10, 25, 50] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
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
                                    <a href="{{ route('mapel.index', array_merge(request()->all(), ['sort' => 'nama_mp', 'direction' => $sortField == 'nama_mp' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                        Nama Mata Pelajaran @if($sortField == 'nama_mp')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                                    </a>
                                </th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mapels as $index => $mapel)
                            <tr>
                                <td>{{ $mapels->firstItem() + $index }}</td>
                                <td><strong>{{ $mapel->nama_mp }}</strong></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('mapel.edit', $mapel) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('mapel.destroy', $mapel) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($mapels->hasPages())
            <div class="card-footer">{{ $mapels->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
