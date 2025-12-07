@extends('layouts.app')

@section('title', 'Detail Sekolah')
@section('page-title', 'Detail Sekolah')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- Left Column: Identity --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-4 position-relative d-inline-block">
                        @if($sekolah->logo)
                            <img src="{{ Storage::url($sekolah->logo) }}" alt="Logo" class="img-fluid rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="avatar-placeholder rounded-circle shadow-sm mx-auto d-flex align-items-center justify-content-center bg-primary text-white" style="width: 150px; height: 150px; font-size: 4rem;">
                                <i class="fas fa-school"></i>
                            </div>
                        @endif
                        @if($sekolah->gambar)
                            <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-1 shadow-sm" title="Foto Gedung">
                                <img src="{{ Storage::url($sekolah->gambar) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            </div>
                        @endif
                    </div>

                    <h3 class="fw-bold text-dark mb-1">{{ $sekolah->nama }}</h3>
                    <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 rounded-pill mb-3">
                        {{ $sekolah->kode }}
                    </span>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('sekolah.edit', $sekolah) }}" class="btn btn-warning text-white">
                            <i class="fas fa-edit me-2"></i>Edit Profil Sekolah
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Details & Stats --}}
        <div class="col-lg-8 mb-4">
            {{-- Stats Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 opacity-75">Total Guru</h6>
                                <h3 class="mb-0 fw-bold">{{ $sekolah->gurus_count ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                                <i class="fas fa-user-graduate fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 opacity-75">Total Siswa</h6>
                                <h3 class="mb-0 fw-bold">{{ $sekolah->siswas_count ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-info text-white h-100">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                                <i class="fas fa-door-open fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 opacity-75">Total Kelas</h6>
                                <h3 class="mb-0 fw-bold">{{ $sekolah->kelas_count ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Information Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Informasi Detail</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="200" class="text-muted fw-medium"><i class="fas fa-user-tie me-2 text-center" style="width:20px"></i>Kepala Sekolah</td>
                                    <td class="fw-bold text-dark">{{ $sekolah->kepala ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium"><i class="fas fa-id-card me-2 text-center" style="width:20px"></i>NIP Kepala Sekolah</td>
                                    <td class="fw-bold text-dark">{{ $sekolah->nip_kepsek ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium"><i class="fas fa-map-marker-alt me-2 text-center" style="width:20px"></i>Alamat</td>
                                    <td class="text-dark">{{ $sekolah->alamat }}</td>
                                </tr>
                                @if($sekolah->created_at)
                                <tr>
                                    <td class="text-muted fw-medium"><i class="fas fa-calendar me-2 text-center" style="width:20px"></i>Terdaftar Sejak</td>
                                    <td class="text-dark">{{ $sekolah->created_at->format('d F Y') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!session('sekolah_id'))
    <div class="mt-3">
        <a href="{{ route('sekolah.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
    @endif
</div>
@endsection
