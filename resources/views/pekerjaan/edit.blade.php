@extends('layouts.app')

@section('title', 'Edit Pekerjaan')
@section('page-title', 'Edit Pekerjaan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Form Edit Pekerjaan
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('pekerjaan.update', $pekerjaan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">
                            Nama Pekerjaan <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama" 
                            class="form-control @error('nama') is-invalid @enderror" 
                            value="{{ old('nama', $pekerjaan->nama) }}" 
                            required
                        >
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <input 
                            type="text" 
                            name="keterangan" 
                            class="form-control" 
                            value="{{ old('keterangan', $pekerjaan->keterangan) }}"
                        >
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pekerjaan.index') }}" class="btn btn-secondary">
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
