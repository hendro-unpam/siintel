@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Siswa')

@section('content')
<div class="table-card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Form Tambah Siswa</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3">
                {{-- Kolom 1: Foto & Data Pribadi --}}
                <div class="col-lg-4">
                    <div class="section-box mb-3">
                        <h6 class="section-title"><i class="fas fa-camera me-2"></i>Foto Siswa</h6>
                        <div class="text-center">
                            <div class="foto-preview-container mb-3">
                                <img id="fotoPreview" src="{{ asset('images/no-photo.png') }}" alt="Preview" class="foto-preview" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22><rect fill=%22%23e5e7eb%22 width=%22150%22 height=%22150%22/><text fill=%22%236b7280%22 font-size=%2214%22 x=%2250%%22 y=%2250%%22 text-anchor=%22middle%22 dy=%22.3em%22>No Photo</text></svg>'">
                            </div>
                            <input type="file" name="foto" id="fotoInput" class="form-control form-control-sm @error('foto') is-invalid @enderror" accept="image/*">
                            @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">JPG, PNG (Max 2MB)</small>
                        </div>
                    </div>
                    
                    <div class="section-box">
                        <h6 class="section-title"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                        <div class="mb-3">
                            <label class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" name="nis" class="form-control form-control-sm @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required>
                            @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jk" class="form-select form-select-sm" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-select form-select-sm" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="tlp" class="form-control form-control-sm" value="{{ old('tlp') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-sm" rows="2">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Data Orang Tua --}}
                <div class="col-lg-4">
                    <div class="section-box h-100">
                        <h6 class="section-title"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="bapak" class="form-control form-control-sm" value="{{ old('bapak') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <select name="pekerjaan_ayah_id" class="form-select form-select-sm">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($pekerjaans as $p)
                                    <option value="{{ $p->id }}" {{ old('pekerjaan_ayah_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="ibu" class="form-control form-control-sm" value="{{ old('ibu') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <select name="pekerjaan_ibu_id" class="form-select form-select-sm">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($pekerjaans as $p)
                                    <option value="{{ $p->id }}" {{ old('pekerjaan_ibu_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Kolom 3: Akun & Aksi --}}
                <div class="col-lg-4">
                    <div class="section-box">
                        <h6 class="section-title"><i class="fas fa-lock me-2"></i>Akun Login</h6>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="section-box mt-3">
                        <h6 class="section-title"><i class="fas fa-cogs me-2"></i>Aksi</h6>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                            <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .section-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
    }
    .section-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }
    .form-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.25rem;
    }
    .foto-preview-container {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border: 3px dashed #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9fafb;
    }
    .foto-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('fotoPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
