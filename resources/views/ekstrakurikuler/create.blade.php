@extends(request()->is('web-admin/*') ? 'layouts.web-admin' : 'layouts.app')

@section('content')
<div class="container-fluid px-4">
    @php
        $isWebAdmin = request()->is('web-admin/*');
        $routePrefix = $isWebAdmin ? 'webadmin.' : '';
    @endphp
    <h1 class="mt-4">Tambah Ekstrakurikuler</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ $isWebAdmin ? route('webadmin.dashboard') : route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route($routePrefix . 'ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Tambah Ekskul
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . 'ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ekstrakurikuler</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Pramuka, Futsal, Tari" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pembina" class="form-label">Nama Pembina</label>
                            <input type="text" class="form-control @error('pembina') is-invalid @enderror" id="pembina" name="pembina" value="{{ old('pembina') }}">
                            @error('pembina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal Latihan</label>
                            <input type="text" class="form-control @error('jadwal') is-invalid @enderror" id="jadwal" name="jadwal" value="{{ old('jadwal') }}" placeholder="Contoh: Setiap Sabtu, 08.00 - 10.00">
                            @error('jadwal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Foto Kegiatan</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                    <div class="form-text">Format: JPG, PNG, GIF. Maks: 2MB.</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Ekskul</button>
                <a href="{{ route($routePrefix . 'ekstrakurikuler.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
