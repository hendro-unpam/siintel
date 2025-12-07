@extends('layouts.frontend')

@section('title', 'Ekstrakurikuler - Sekolah Insan Teladan')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>Ekstrakurikuler</h1>
        <p>Kegiatan pengembangan bakat dan minat siswa</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="intro-section">
            <p>
                Terdapat beberapa kegiatan ekstrakurikuler yang dapat diikuti oleh para siswa, diantaranya:
            </p>
        </div>
        
        @if($ekstrakurikulers->count() > 0)
        <div class="grid grid-3">
            @foreach($ekstrakurikulers as $ekskul)
            <div class="ekskul-card">
                <div class="ekskul-image">
                    @if($ekskul->gambar)
                        <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="{{ $ekskul->nama }}">
                    @else
                        <div class="ekskul-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </div>
                <div class="ekskul-content">
                    <h3 class="ekskul-title">{{ $ekskul->nama }}</h3>
                    <p class="ekskul-desc">{{ $ekskul->deskripsi }}</p>
                    <div class="ekskul-meta">
                        <div class="meta-item">
                            <i class="fas fa-user-tie"></i>
                            <span>{{ $ekskul->pembina }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $ekskul->jadwal }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="no-data">
            <i class="fas fa-info-circle"></i>
            <p>Data ekstrakurikuler akan segera ditambahkan</p>
        </div>
        @endif

        <div class="manfaat-section">
            <h3>Manfaat Mengikuti Ekstrakurikuler</h3>
            <div class="grid grid-2">
                <div class="manfaat-card">
                    <div class="manfaat-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h4>Mengembangkan Bakat</h4>
                    <p>Menyalurkan dan mengasah bakat serta minat siswa di berbagai bidang</p>
                </div>
                
                <div class="manfaat-card">
                    <div class="manfaat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Meningkatkan Kemampuan Sosial</h4>
                    <p>Belajar berinteraksi, bekerjasama, dan berorganisasi dengan teman sebaya</p>
                </div>
                
                <div class="manfaat-card">
                    <div class="manfaat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>Meraih Prestasi</h4>
                    <p>Kesempatan untuk mengikuti kompetisi dan meraih prestasi di tingkat lokal hingga nasional</p>
                </div>
                
                <div class="manfaat-card">
                    <div class="manfaat-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h4>Keseimbangan Akademik</h4>
                    <p>Menyeimbangkan kegiatan akademik dengan pengembangan soft skills dan hobi</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
