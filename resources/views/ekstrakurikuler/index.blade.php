@extends(request()->is('web-admin/*') ? 'layouts.web-admin' : 'layouts.app')

@section('content')
<div class="container-fluid px-4">
    @php
        $isWebAdmin = request()->is('web-admin/*');
        $routePrefix = $isWebAdmin ? 'webadmin.' : '';
    @endphp
    <h1 class="mt-4">Manajemen Ekstrakurikuler</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ $isWebAdmin ? route('webadmin.dashboard') : route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Ekstrakurikuler</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-running me-1"></i> Daftar Ekstrakurikuler</div>
            <a href="{{ route($routePrefix . 'ekstrakurikuler.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Ekskul
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Gambar</th>
                            <th>Nama Ekskul</th>
                            <th>Pembina</th>
                            <th>Jadwal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ekstrakurikulers as $index => $ekskul)
                        <tr>
                            <td>{{ $ekstrakurikulers->firstItem() + $index }}</td>
                            <td>
                                @if($ekskul->gambar)
                                    <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="Thumbnail" width="80" class="img-thumbnail">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $ekskul->nama }}</td>
                            <td>{{ $ekskul->pembina }}</td>
                            <td>{{ $ekskul->jadwal }}</td>
                            <td>
                                <a href="{{ route($routePrefix . 'ekstrakurikuler.edit', $ekskul->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route($routePrefix . 'ekstrakurikuler.destroy', $ekskul->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ekskul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data ekstrakurikuler.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $ekstrakurikulers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
