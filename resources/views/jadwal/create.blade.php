@extends('layouts.app')

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>Form Tambah Jadwal
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Hari <span class="text-danger">*</span>
                                </label>
                                <select name="hari_id" class="form-select @error('hari_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Hari --</option>
                                    @foreach ($haris as $hari)
                                        <option 
                                            value="{{ $hari->id }}" 
                                            {{ old('hari_id') == $hari->id ? 'selected' : '' }}
                                        >
                                            {{ $hari->hari }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('hari_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Mata Pelajaran <span class="text-danger">*</span>
                                </label>
                                <select name="mata_pelajaran_id" class="form-select @error('mata_pelajaran_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach ($mapels as $mapel)
                                        <option 
                                            value="{{ $mapel->id }}" 
                                            {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}
                                        >
                                            {{ $mapel->nama_mp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mata_pelajaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Jam Mulai <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="time" 
                                    name="jam_mulai" 
                                    class="form-control @error('jam_mulai') is-invalid @enderror" 
                                    value="{{ old('jam_mulai') }}" 
                                    required
                                >
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Kelas <span class="text-danger">*</span>
                                </label>
                                <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option 
                                            value="{{ $k->id }}" 
                                            {{ old('kelas_id') == $k->id ? 'selected' : '' }}
                                        >
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Guru Pengajar <span class="text-danger">*</span>
                                </label>
                                <select name="guru_id" class="form-select @error('guru_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $guru)
                                        <option 
                                            value="{{ $guru->id }}" 
                                            {{ old('guru_id') == $guru->id ? 'selected' : '' }}
                                        >
                                            {{ $guru->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Jam Selesai <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="time" 
                                    name="jam_selesai" 
                                    class="form-control @error('jam_selesai') is-invalid @enderror" 
                                    value="{{ old('jam_selesai') }}" 
                                    required
                                >
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                name="aktif" 
                                class="form-check-input" 
                                id="aktif" 
                                value="1" 
                                {{ old('aktif', true) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="aktif">
                                Jadwal Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">
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
