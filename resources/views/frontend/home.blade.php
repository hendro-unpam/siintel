@extends('layouts.frontend')

@section('title', 'Beranda - Sekolah Insan Teladan')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="container">
            <div class="hero-text">
                <h1 class="hero-title animate-fade-in-up">
                    Selamat Datang di<br>
                    <span class="text-primary">Sekolah Insan Teladan</span>
                </h1>
                <p class="hero-subtitle animate-fade-in-up" style="animation-delay: 0.2s;">
                    Menumbuhkan Generasi Penerus Bangsa Yang Cerdas, Peduli, 
                    Berkarakter Baik Berdasarkan Nilai-Nilai Kemanusiaan dan Menjadi Manusia Seutuhnya
                </p>
                <div class="hero-buttons animate-fade-in-up" style="animation-delay: 0.4s;">
                    <a href="{{ url('/tentang') }}" class="btn btn-primary">
                        <i class="fas fa-info-circle"></i> Tentang Kami
                    </a>
                    <a href="{{ url('/hubungi') }}" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-overlay"></div>
</section>

<!-- Visi Misi Section -->
<section class="section visi-misi-section">
    <div class="container">
        <div class="section-title">
            <h2>Visi & Misi Kami</h2>
            <p>Komitmen kami dalam membentuk generasi unggul</p>
        </div>
        
        <div class="visi-misi-grid">
            <div class="visi-misi-card animate-on-scroll">
                <div class="visi-misi-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Visi</h3>
                <p>
                    "Menumbuhkan Kembangkan Generasi Penerus Bangsa Yang Cerdas, Peduli, 
                    Berkarakter Baik Berdasarkan Nilai-Nilai Kemanusiaan Dan Menjadi Manusia Seutuhnya"
                </p>
            </div>
            
            <div class="visi-misi-card animate-on-scroll" style="animation-delay: 0.2s;">
                <div class="visi-misi-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Misi</h3>
                <ul class="misi-list">
                    <li><i class="fas fa-check-circle"></i> Mendirikan dan menyelenggarakan sekolah berbasis nilai-nilai kemanusiaan</li>
                    <li><i class="fas fa-check-circle"></i> Mensosialisasikan program pendidikan kepada masyarakat</li>
                    <li><i class="fas fa-check-circle"></i> Menjadikan sekolah sebagai model yang melaksanakan pendidikan berkarakter</li>
                    <li><i class="fas fa-check-circle"></i> Menyelenggarakan pendidikan yang mengkombinasikan pengembangan budi pekerti</li>
                    <li><i class="fas fa-check-circle"></i> Memberikan kesempatan memperoleh pendidikan bermutu</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="section why-choose-section bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Mengapa Memilih Kami?</h2>
            <p>Keunggulan Sekolah Insan Teladan</p>
        </div>
        
        <div class="grid grid-3">
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Pendidikan Berkualitas</h3>
                <p>Kurikulum nasional yang diperkaya dengan program pengembangan karakter</p>
            </div>
            <div class="feature-card animate-on-scroll" style="animation-delay: 0.1s;">
                <div class="feature-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3>Guru Profesional</h3>
                <p>Tenaga pendidik berkualitas dan berpengalaman di bidangnya</p>
            </div>
            <div class="feature-card animate-on-scroll" style="animation-delay: 0.2s;">
                <div class="feature-icon"><i class="fas fa-building"></i></div>
                <h3>Fasilitas Lengkap</h3>
                <p>Ruang kelas nyaman, perpustakaan, lab, dan area olahraga yang memadai</p>
            </div>
            <div class="feature-card animate-on-scroll" style="animation-delay: 0.3s;">
                <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                <h3>Prestasi Membanggakan</h3>
                <p>Siswa-siswi berprestasi di berbagai bidang akademik dan non-akademik</p>
            </div>
            <div class="feature-card animate-on-scroll" style="animation-delay: 0.4s;">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Lingkungan Kondusif</h3>
                <p>Suasana belajar yang menyenangkan dan mendukung perkembangan anak</p>
            </div>
            <div class="feature-card animate-on-scroll" style="animation-delay: 0.5s;">
                <div class="feature-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h3>Pendidikan Karakter</h3>
                <p>Fokus pada pembentukan akhlak dan nilai-nilai kemanusiaan</p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Achievement Section -->
@if($prestasis->count() > 0)
<section class="section prestasi-section">
    <div class="container">
        <div class="section-title">
            <h2>Prestasi Terkini</h2>
            <p>Kebanggaan siswa-siswi Insan Teladan</p>
        </div>
        
        <div class="grid grid-3">
            @foreach($prestasis as $prestasi)
            <div class="card animate-on-scroll">
                <div class="card-image">
                    @if($prestasi->gambar)
                        <img src="{{ asset('storage/' . $prestasi->gambar) }}" alt="{{ $prestasi->judul }}">
                    @else
                        <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ $prestasi->judul }}">
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-meta">
                        <span class="badge {{ $prestasi->kategori == 'akademik' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ ucfirst($prestasi->kategori) }}
                        </span>
                        <span><i class="fas fa-calendar"></i> {{ $prestasi->tanggal->format('d M Y') }}</span>
                    </div>
                    <h3 class="card-title">{{ $prestasi->judul }}</h3>
                    <p class="card-text">
                        <strong>{{ $prestasi->nama_siswa }}</strong> - Kelas {{ $prestasi->kelas }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ url('/prestasi') }}" class="btn btn-primary">
                Lihat Semua Prestasi <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Latest News Section -->
@if($beritas->count() > 0)
<section class="section berita-section bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Berita Terbaru</h2>
            <p>Informasi dan kegiatan terkini sekolah</p>
        </div>
        
        <div class="grid grid-3">
            @foreach($beritas as $berita)
            <div class="card animate-on-scroll">
                <div class="card-image">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                    @else
                        <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ $berita->judul }}">
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-meta">
                        <span><i class="fas fa-calendar"></i> {{ $berita->tanggal_post->format('d M Y') }}</span>
                        <span><i class="fas fa-user"></i> {{ $berita->penulis }}</span>
                    </div>
                    <h3 class="card-title">{{ $berita->judul }}</h3>
                    <p class="card-text">{{ Str::limit(strip_tags($berita->konten), 120) }}</p>
                    <a href="{{ url('/berita/' . $berita->id) }}" class="btn btn-outline">
                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ url('/berita') }}" class="btn btn-primary">
                Lihat Semua Berita <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif
@endsection
