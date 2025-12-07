@extends(request()->is('web-admin/*') ? 'layouts.web-admin' : 'layouts.app')

@section('content')
<div class="container-fluid px-4">
    @php
        $isWebAdmin = request()->is('web-admin/*');
        $routePrefix = $isWebAdmin ? 'webadmin.' : '';
    @endphp
    <h1 class="mt-4">Edit Ekstrakurikuler</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ $isWebAdmin ? route('webadmin.dashboard') : route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route($routePrefix . 'ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Ekskul
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . 'ekstrakurikuler.update', $ekstrakurikuler->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ekstrakurikuler</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $ekstrakurikuler->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pembina" class="form-label">Nama Pembina</label>
                            <input type="text" class="form-control @error('pembina') is-invalid @enderror" id="pembina" name="pembina" value="{{ old('pembina', $ekstrakurikuler->pembina) }}">
                            @error('pembina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal Latihan</label>
                            <input type="text" class="form-control @error('jadwal') is-invalid @enderror" id="jadwal" name="jadwal" value="{{ old('jadwal', $ekstrakurikuler->jadwal) }}">
                            @error('jadwal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Foto Kegiatan</label>
                    @if($ekstrakurikuler->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $ekstrakurikuler->gambar) }}" alt="Current Image" width="150" class="img-thumbnail">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $ekstrakurikuler->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Ekskul</button>
                <a href="{{ route($routePrefix . 'ekstrakurikuler.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
