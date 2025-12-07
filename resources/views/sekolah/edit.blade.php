@extends('layouts.app')

@section('title', 'Edit Sekolah')
@section('page-title', 'Edit Sekolah')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Form Edit Sekolah
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('sekolah.update', $sekolah) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Kode Sekolah <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="kode" 
                                    class="form-control @error('kode') is-invalid @enderror" 
                                    value="{{ old('kode', $sekolah->kode) }}" 
                                    required
                                >
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Nama Sekolah <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama" 
                                    class="form-control @error('nama') is-invalid @enderror" 
                                    value="{{ old('nama', $sekolah->nama) }}" 
                                    required
                                >
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kepala Sekolah</label>
                                <input 
                                    type="text" 
                                    name="kepala" 
                                    class="form-control" 
                                    value="{{ old('kepala', $sekolah->kepala) }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NIP Kepala Sekolah</label>
                                <input 
                                    type="text" 
                                    name="nip_kepsek" 
                                    class="form-control" 
                                    value="{{ old('nip_kepsek', $sekolah->nip_kepsek) }}"
                                >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Alamat <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    name="alamat" 
                                    class="form-control @error('alamat') is-invalid @enderror" 
                                    rows="3" 
                                    required
                                >{{ old('alamat', $sekolah->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Logo Sekolah</label>
                                        <div class="mb-2 text-center">
                                            <img id="logo-preview" src="{{ $sekolah->logo ? Storage::url($sekolah->logo) : asset('images/no-image.png') }}" 
                                                 alt="Preview Logo" class="img-thumbnail {{ $sekolah->logo ? '' : 'd-none' }}" style="max-height: 100px;">
                                        </div>
                                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Background</label>
                                        <div class="mb-2 text-center">
                                            <img id="gambar-preview" src="{{ $sekolah->gambar ? Storage::url($sekolah->gambar) : asset('images/no-image.png') }}" 
                                                 alt="Preview Background" class="img-thumbnail {{ $sekolah->gambar ? '' : 'd-none' }}" style="max-height: 100px;">
                                        </div>
                                        <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'gambar-preview')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sekolah.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
