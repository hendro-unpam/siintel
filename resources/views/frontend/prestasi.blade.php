@extends('layouts.frontend')

@section('title', 'Prestasi - Sekolah Insan Teladan')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        @if(isset($sekolah) && $sekolah)
        <h1>Prestasi {{ $sekolah->nama }}</h1>
        <p>Pencapaian gemilang siswa {{ $sekolah->nama }}</p>
        <a href="{{ url('/prestasi' . (request('kategori') ? '?kategori=' . request('kategori') : '')) }}" style="display: inline-block; margin-top: 10px; background: white; color: #10b981; padding: 8px 16px; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">
            <i class="fas fa-times"></i> Hapus Filter Sekolah
        </a>
        @else
        <h1>Prestasi {{ request('kategori') == 'akademik' ? 'Akademik' : (request('kategori') == 'non_akademik' ? 'Non Akademik' : 'Siswa') }}</h1>
        <p>Pencapaian gemilang siswa di bidang {{ request('kategori') == 'akademik' ? 'akademik' : (request('kategori') == 'non_akademik' ? 'non akademik' : 'berbagai bidang') }}</p>
        @endif
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 900px; margin: 0 auto 40px; text-align: center;">
            <p style="font-size: 1.05rem; line-height: 1.8; color: #6b7280; margin: 0;">
                Kami sangat bangga dengan siswa-siswa kami yang berprestasi di luar kelas. 
                Halaman ini adalah bentuk apresiasi kami atas kerja keras, dedikasi, dan bakat luar biasa 
                mereka yang telah diakui secara lokal, regional, maupun nasional. Kami percaya bahwa 
                setiap pencapaian mereka menjadi sumber inspirasi bagi seluruh komunitas sekolah.
            </p>
        </div>
        
        <!-- Filter Kategori -->
        <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 2rem; flex-wrap: wrap;">
            <a href="{{ url('/prestasi') }}" style="padding: 10px 24px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s; {{ !request('kategori') ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 4px 15px rgba(16,185,129,0.3);' : 'background: #f3f4f6; color: #374151;' }}">
                Semua
            </a>
            <a href="{{ url('/prestasi?kategori=akademik') }}" style="padding: 10px 24px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s; {{ request('kategori') == 'akademik' ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 4px 15px rgba(16,185,129,0.3);' : 'background: #f3f4f6; color: #374151;' }}">
                <i class="fas fa-graduation-cap"></i> Akademik
            </a>
            <a href="{{ url('/prestasi?kategori=non_akademik') }}" style="padding: 10px 24px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s; {{ request('kategori') == 'non_akademik' ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 4px 15px rgba(16,185,129,0.3);' : 'background: #f3f4f6; color: #374151;' }}">
                <i class="fas fa-trophy"></i> Non Akademik
            </a>
        </div>
        
        @if($prestasis->count() > 0)
        <div class="grid grid-3">
            @foreach($prestasis as $p)
            <div class="card prestasi-card">
                <div class="card-image" style="position: relative; overflow: hidden;">
                    @if($p->gambar)
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->judul }}" style="border-radius: 12px 12px 0 0;">
                    @else
                        <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ $p->judul }}" style="border-radius: 12px 12px 0 0;">
                    @endif
                    <div style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                        <span style="display: inline-block; background: {{ $p->kategori == 'akademik' ? '#10b981' : '#f59e0b' }}; color: white; padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                            {{ $p->kategori == 'akademik' ? 'Akademik' : 'Non Akademik' }}
                        </span>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-meta">
                        <span><i class="fas fa-calendar"></i> {{ $p->tanggal->format('d M Y') }}</span>
                    </div>
                    @if($p->sekolah)
                    @php
                        $nama = strtolower($p->sekolah->nama);
                        if (str_contains($nama, 'tk')) {
                            $bgColor = 'linear-gradient(135deg, #ec4899, #f472b6)';
                        } elseif (str_contains($nama, 'sd')) {
                            $bgColor = 'linear-gradient(135deg, #3b82f6, #60a5fa)';
                        } elseif (str_contains($nama, 'smp')) {
                            $bgColor = 'linear-gradient(135deg, #8b5cf6, #a78bfa)';
                        } else {
                            $bgColor = 'linear-gradient(135deg, #10b981, #34d399)';
                        }
                    @endphp
                    <a href="{{ url('/prestasi?sekolah=' . $p->sekolah->id . (request('kategori') ? '&kategori=' . request('kategori') : '')) }}" style="display: inline-block; background: {{ $bgColor }}; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; margin-bottom: 8px; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                        <i class="fas fa-school"></i> {{ $p->sekolah->nama }}
                    </a>
                    @endif
                    <h3 class="card-title">{{ $p->judul }}</h3>
                    <div class="student-info">
                        <i class="fas fa-user-graduate"></i>
                        <div>
                            <strong>{{ $p->nama_siswa }}</strong>
                            <span>{{ $p->kelas }}</span>
                        </div>
                    </div>
                    @if($p->deskripsi)
                        <p class="card-text">{{ Str::limit($p->deskripsi, 120) }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($prestasis->hasPages())
        <div style="display: flex; justify-content: center; gap: 8px; margin-top: 2rem; flex-wrap: wrap;">
            @if($prestasis->onFirstPage())
                <span class="btn btn-outline" style="opacity: 0.5; cursor: not-allowed; padding: 8px 16px; border-radius: 8px;">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </span>
            @else
                <a href="{{ $prestasis->previousPageUrl() }}" class="btn btn-outline" style="padding: 8px 16px; border-radius: 8px; text-decoration: none;">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
            @endif
            
            @foreach($prestasis->getUrlRange(1, $prestasis->lastPage()) as $page => $url)
                @if($page == $prestasis->currentPage())
                    <span class="btn btn-primary" style="padding: 8px 14px; border-radius: 8px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="btn btn-outline" style="padding: 8px 14px; border-radius: 8px; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach
            
            @if($prestasis->hasMorePages())
                <a href="{{ $prestasis->nextPageUrl() }}" class="btn btn-outline" style="padding: 8px 16px; border-radius: 8px; text-decoration: none;">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="btn btn-outline" style="opacity: 0.5; cursor: not-allowed; padding: 8px 16px; border-radius: 8px;">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
        @endif
        
        @else
        <div class="no-data">
            <i class="fas fa-trophy"></i>
            <p>Belum ada data prestasi</p>
        </div>
        @endif
    </div>
</section>
@endsection
