@extends('layouts.app')

@section('title', 'Tambah Kategori Ujian')
@section('page-title', 'Tambah Kategori Ujian')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Form Tambah Kategori</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('ujian-kategori.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                            value="{{ old('nama_kategori') }}" placeholder="Contoh: UTS, UAS, UH, Tugas, Kuis" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" 
                            value="{{ old('keterangan') }}" placeholder="Keterangan (opsional)">
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('ujian-kategori.index') }}" class="btn btn-secondary">
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
