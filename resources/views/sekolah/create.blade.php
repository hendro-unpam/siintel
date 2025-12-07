@extends('layouts.app')

@section('title', 'Tambah Sekolah')
@section('page-title', 'Tambah Sekolah')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>Form Tambah Sekolah
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('sekolah.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                                    value="{{ old('kode') }}" 
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
                                    value="{{ old('nama') }}" 
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
                                    value="{{ old('kepala') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NIP Kepala Sekolah</label>
                                <input 
                                    type="text" 
                                    name="nip_kepsek" 
                                    class="form-control" 
                                    value="{{ old('nip_kepsek') }}"
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
                                >{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Logo Sekolah</label>
                                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Background</label>
                                        <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*">
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
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
