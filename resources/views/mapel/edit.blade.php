@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')
@section('page-title', 'Edit Mata Pelajaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Form Edit Mata Pelajaran
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('mapel.update', $mapel) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">
                            Nama Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_mp" 
                            class="form-control @error('nama_mp') is-invalid @enderror" 
                            value="{{ old('nama_mp', $mapel->nama_mp) }}" 
                            required
                        >
                        @error('nama_mp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mapel.index') }}" class="btn btn-secondary">
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
@endsection
