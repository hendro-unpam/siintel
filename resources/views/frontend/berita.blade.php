@extends('layouts.frontend')

@section('title', 'Berita - Sekolah Insan Teladan')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        @if(isset($sekolah) && $sekolah)
        <h1>Berita {{ $sekolah->nama }}</h1>
        <p>Menampilkan berita dari {{ $sekolah->nama }}</p>
        <a href="{{ url('/berita') }}" style="display: inline-block; margin-top: 10px; background: white; color: #10b981; padding: 8px 16px; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">
            <i class="fas fa-times"></i> Hapus Filter
        </a>
        @else
        <h1>Pembaruan Terbaru</h1>
        <p>Berita dan informasi terkini dari Sekolah Insan Teladan</p>
        @endif
    </div>
</div>

<section class="section">
    <div class="container">
        @if($beritas->count() > 0)
        <div class="grid grid-3">
            @foreach($beritas as $b)
            <div class="card berita-card">
                <div class="card-image">
                    @if($b->gambar)
                        <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->judul }}">
                    @else
                        <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ $b->judul }}">
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-meta">
                        <span><i class="fas fa-calendar"></i> {{ $b->tanggal_post->format('d M Y') }}</span>
                        <span><i class="fas fa-user"></i> {{ $b->penulis }}</span>
                    </div>
                    @if($b->sekolah)
                    @php
                        // Color based on school level
                        $nama = strtolower($b->sekolah->nama);
                        if (str_contains($nama, 'tk')) {
                            $bgColor = 'linear-gradient(135deg, #ec4899, #f472b6)'; // Pink for TK
                        } elseif (str_contains($nama, 'sd')) {
                            $bgColor = 'linear-gradient(135deg, #3b82f6, #60a5fa)'; // Blue for SD
                        } elseif (str_contains($nama, 'smp')) {
                            $bgColor = 'linear-gradient(135deg, #8b5cf6, #a78bfa)'; // Purple for SMP
                        } else {
                            $bgColor = 'linear-gradient(135deg, #10b981, #34d399)'; // Green default
                        }
                    @endphp
                    <a href="{{ url('/berita/' . $b->id . '?filter=sekolah') }}" class="badge-sekolah" style="display: inline-block; background: {{ $bgColor }}; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; margin-bottom: 8px; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                        <i class="fas fa-school"></i> {{ $b->sekolah->nama }}
                    </a>
                    @endif
                    <h3 class="card-title">
                        <a href="{{ url('/berita/' . $b->id) }}">
                            {{ $b->judul }}
                        </a>
                    </h3>
                    <p class="card-text">{{ Str::limit(strip_tags($b->konten), 150) }}</p>
                    <div class="card-footer">
                        <a href="{{ url('/berita/' . $b->id) }}" class="btn btn-outline btn-sm">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($beritas->hasPages())
        <div class="pagination-wrapper" style="display: flex; justify-content: center; gap: 8px; margin-top: 2rem; flex-wrap: wrap;">
            {{-- Previous Page --}}
            @if($beritas->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed; padding: 8px 16px; border-radius: 8px;">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </span>
            @else
                <a href="{{ $beritas->previousPageUrl() }}" class="btn btn-outline btn-sm" style="padding: 8px 16px; border-radius: 8px; text-decoration: none;">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                @if($page == $beritas->currentPage())
                    <span class="btn btn-primary btn-sm" style="padding: 8px 14px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #34d399); border: none; color: white;">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="btn btn-outline btn-sm" style="padding: 8px 14px; border-radius: 8px; text-decoration: none; border: 2px solid #10b981; color: #10b981;">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next Page --}}
            @if($beritas->hasMorePages())
                <a href="{{ $beritas->nextPageUrl() }}" class="btn btn-outline btn-sm" style="padding: 8px 16px; border-radius: 8px; text-decoration: none;">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed; padding: 8px 16px; border-radius: 8px;">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
        @endif
        
        @else
        <div class="no-data">
            <i class="fas fa-newspaper"></i>
            <p>Belum ada berita yang dipublikasikan</p>
        </div>
        @endif
    </div>
</section>
@endsection
