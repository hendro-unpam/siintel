@extends('layouts.app')

@section('title', 'Kategori Ujian')
@section('page-title', 'Kategori Ujian')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Daftar Kategori Ujian</h5>
            <a href="{{ route('ujian-kategori.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Kategori
            </a>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th width="100" class="text-center">Jumlah Ujian</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kategori)
                    <tr>
                        <td>{{ $kategoris->firstItem() + $index }}</td>
                        <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                        <td class="text-muted">{{ $kategori->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $kategori->ujians_count }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('ujian-kategori.edit', $kategori) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('ujian-kategori.destroy', $kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada kategori ujian</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($kategoris->hasPages())
    <div class="card-footer">
        {{ $kategoris->links() }}
    </div>
    @endif
</div>

<div class="mt-3">
    <a href="{{ route('ujian.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Ujian
    </a>
</div>
@endsection
