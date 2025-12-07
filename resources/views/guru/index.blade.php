@extends('layouts.app')

@section('title', 'Data Guru')
@section('page-title', 'Data Guru')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Daftar Guru</h5>
            <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Guru
            </a>
        </div>
        
        <div class="row g-2 mt-3">
            <div class="col-md-4">
                <form action="{{ route('guru.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari NIP, nama, alamat..." value="{{ request('search') }}">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
                    @endif
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <form action="{{ route('guru.index') }}" method="GET" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label class="form-label mb-0 small">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="small text-muted">dari {{ $gurus->total() }} data</span>
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
                            <a href="{{ route('guru.index', array_merge(request()->all(), ['sort' => 'nip', 'direction' => $sortField == 'nip' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                NIP @if($sortField == 'nip')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('guru.index', array_merge(request()->all(), ['sort' => 'nama', 'direction' => $sortField == 'nama' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                Nama @if($sortField == 'nama')<i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                            </a>
                        </th>
                        <th>JK</th>
                        <th>Alamat</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $index => $guru)
                    <tr>
                        <td>{{ $gurus->firstItem() + $index }}</td>
                        <td><code>{{ $guru->nip }}</code></td>
                        <td><strong>{{ $guru->nama }}</strong></td>
                        <td><span class="badge {{ $guru->jk == 'L' ? 'bg-primary' : 'bg-pink' }}">{{ $guru->jk }}</span></td>
                        <td>{{ Str::limit($guru->alamat, 30) ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('guru.show', $guru) }}" class="btn btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('guru.edit', $guru) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('guru.destroy', $guru) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            @if(request('search')) Tidak ada hasil @else Belum ada data @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($gurus->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $gurus->firstItem() }} - {{ $gurus->lastItem() }} dari {{ $gurus->total() }}</small>
        {{ $gurus->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>.bg-pink { background-color: #ec4899 !important; }</style>
@endpush
