@extends(request()->is('web-admin/*') ? 'layouts.web-admin' : 'layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Berita</h1>
    @php
        $isWebAdmin = request()->is('web-admin/*');
        $routePrefix = $isWebAdmin ? 'webadmin.' : '';
    @endphp
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ $isWebAdmin ? route('webadmin.dashboard') : route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route($routePrefix . 'berita.index') }}">Berita</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Berita
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . 'berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_post" class="form-label">Tanggal Post</label>
                    <input type="date" class="form-control @error('tanggal_post') is-invalid @enderror" id="tanggal_post" name="tanggal_post" value="{{ old('tanggal_post', $berita->tanggal_post->format('Y-m-d')) }}" required>
                    @error('tanggal_post')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Utama</label>
                    @if($berita->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Current Image" width="150" class="img-thumbnail">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="konten" class="form-label">Konten Berita</label>
                    <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="10" required>{{ old('konten', $berita->konten) }}</textarea>
                    @error('konten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}">
                </div>

                <button type="submit" class="btn btn-primary">Update Berita</button>
                <a href="{{ route($routePrefix . 'berita.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
