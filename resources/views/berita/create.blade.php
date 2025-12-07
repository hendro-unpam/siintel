@extends(request()->is('web-admin/*') ? 'layouts.web-admin' : 'layouts.app')

@section('content')
<div class="container-fluid px-4">
    @php
        $isWebAdmin = request()->is('web-admin/*');
        $routePrefix = $isWebAdmin ? 'webadmin.' : '';
    @endphp
    <h1 class="mt-4">Tambah Berita</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ $isWebAdmin ? route('webadmin.dashboard') : route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route($routePrefix . 'berita.index') }}">Berita</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Tambah Berita
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . 'berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_post" class="form-label">Tanggal Post</label>
                    <input type="date" class="form-control @error('tanggal_post') is-invalid @enderror" id="tanggal_post" name="tanggal_post" value="{{ old('tanggal_post', date('Y-m-d')) }}" required>
                    @error('tanggal_post')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Utama</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                    <div class="form-text">Format: JPG, PNG, GIF. Maks: 2MB.</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="konten" class="form-label">Konten Berita</label>
                    <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="10" required>{{ old('konten') }}</textarea>
                    @error('konten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', 'Admin') }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Berita</button>
                <a href="{{ route($routePrefix . 'berita.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
