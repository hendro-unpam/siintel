@extends('layouts.app')

@section('title', 'Edit Kelas')
@section('page-title', 'Edit Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Form Edit Kelas
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('kelas.update', $kela) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">
                            Sekolah <span class="text-danger">*</span>
                        </label>
                        <select name="sekolah_id" class="form-select @error('sekolah_id') is-invalid @enderror" required>
                            @foreach ($sekolahs as $s)
                                <option 
                                    value="{{ $s->id }}" 
                                    {{ old('sekolah_id', $kela->sekolah_id) == $s->id ? 'selected' : '' }}
                                >
                                    {{ $s->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('sekolah_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama" 
                            class="form-control @error('nama') is-invalid @enderror" 
                            value="{{ old('nama', $kela->nama) }}" 
                            required
                        >
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
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
