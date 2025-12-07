@extends('layouts.app')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Guru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>Form Edit Guru
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('guru.update', $guru) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    NIP <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nip" 
                                    class="form-control @error('nip') is-invalid @enderror" 
                                    value="{{ old('nip', $guru->nip) }}" 
                                    required
                                >
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama" 
                                    class="form-control @error('nama') is-invalid @enderror" 
                                    value="{{ old('nama', $guru->nama) }}" 
                                    required
                                >
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <select name="jk" class="form-select" required>
                                    <option value="L" {{ old('jk', $guru->jk) == 'L' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="P" {{ old('jk', $guru->jk) == 'P' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea 
                                    name="alamat" 
                                    class="form-control" 
                                    rows="3"
                                >{{ old('alamat', $guru->alamat) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Password Baru 
                                    <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small>
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="form-control @error('password') is-invalid @enderror"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">
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
