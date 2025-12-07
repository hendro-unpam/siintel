@extends('layouts.frontend')

@section('title', $berita->judul . ' - Sekolah Insan Teladan')

@section('content')
<section class="section">
    <div class="container">
        <div class="berita-detail-wrapper" style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
            <article class="berita-detail">
                <h1 class="berita-title" style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem; color: #1f2937;">{{ $berita->judul }}</h1>
                
                <div class="berita-meta" style="display: flex; gap: 1.5rem; margin-bottom: 1rem; color: #6b7280; font-size: 0.9rem;">
                    <span><i class="fas fa-calendar"></i> {{ $berita->tanggal_post->format('d F Y') }}</span>
                    <span><i class="fas fa-user"></i> {{ $berita->penulis }}</span>
                    <span><i class="fas fa-eye"></i> {{ number_format($berita->views) }} views</span>
                </div>

                @if($berita->sekolah)
                @php
                    $nama = strtolower($berita->sekolah->nama);
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
                <a href="{{ url('/berita?sekolah=' . $berita->sekolah->id) }}" style="display: inline-block; background: {{ $bgColor }}; color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1rem; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                    <i class="fas fa-school"></i> {{ $berita->sekolah->nama }}
                </a>
                @endif
                
                @if($berita->gambar)
                <div class="berita-image" style="margin-bottom: 1.5rem;">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                </div>
                @endif
                
                <div class="berita-content" style="line-height: 1.8; color: #374151; font-size: 1rem;">
                    {!! nl2br(e($berita->konten)) !!}
                </div>
                
                <div class="berita-footer" style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <a href="{{ url('/berita') }}" class="btn btn-secondary" style="background: #6b7280; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Berita
                    </a>
                </div>
            </article>
            
            <aside class="berita-sidebar" style="background: #f9fafb; padding: 1.5rem; border-radius: 12px; height: fit-content;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #1f2937; border-bottom: 2px solid #10b981; padding-bottom: 0.5rem;">
                    <i class="fas fa-newspaper"></i> 
                    @if(isset($filterSekolah) && $filterSekolah)
                        Berita {{ $berita->sekolah->nama ?? '' }}
                    @else
                        Berita Terbaru
                    @endif
                </h3>
                @if(isset($filterSekolah) && $filterSekolah)
                <div style="margin-bottom: 1rem;">
                    <a href="{{ url('/berita/' . $berita->id) }}" style="font-size: 0.75rem; color: #10b981; text-decoration: none;">
                        <i class="fas fa-globe"></i> Lihat Semua Sekolah
                    </a>
                </div>
                @endif
                @if($latestBerita->count() > 0)
                    @foreach($latestBerita as $lb)
                    <div class="sidebar-berita-item" style="padding: 1rem 0; border-bottom: 1px solid #e5e7eb;">
                        <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">
                            <i class="fas fa-calendar-alt"></i> {{ $lb->tanggal_post->format('d M Y') }}
                            @if($lb->sekolah)
                            @php
                                $lbNama = strtolower($lb->sekolah->nama);
                                if (str_contains($lbNama, 'tk')) {
                                    $lbColor = '#ec4899';
                                } elseif (str_contains($lbNama, 'sd')) {
                                    $lbColor = '#3b82f6';
                                } elseif (str_contains($lbNama, 'smp')) {
                                    $lbColor = '#8b5cf6';
                                } else {
                                    $lbColor = '#10b981';
                                }
                            @endphp
                            <a href="{{ url('/berita?sekolah=' . $lb->sekolah->id) }}" style="background: {{ $lbColor }}; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.65rem; margin-left: 5px; text-decoration: none;">
                                {{ $lb->sekolah->nama }}
                            </a>
                            @endif
                        </div>
                        <h4 style="font-size: 0.9rem; font-weight: 600; margin: 0;">
                            <a href="{{ url('/berita/' . $lb->id) }}" style="color: #1f2937; text-decoration: none;">
                                {{ Str::limit($lb->judul, 50) }}
                            </a>
                        </h4>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0.5rem 0 0;">{{ Str::limit(strip_tags($lb->konten), 80) }}</p>
                    </div>
                    @endforeach
                @else
                    <p style="color: #6b7280; font-size: 0.9rem;">Tidak ada berita lainnya</p>
                @endif
            </aside>
        </div>
    </div>
</section>

<style>
@media (max-width: 992px) {
    .berita-detail-wrapper {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
