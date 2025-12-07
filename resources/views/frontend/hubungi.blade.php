@extends('layouts.frontend')

@section('title', 'Hubungi Kami - Sekolah Insan Teladan')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/hubungi.css') }}">
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>Hubungi Kami</h1>
        <p>Kami sangat terbuka dengan masukan dari anda. Apakah ada pertanyaan lebih lanjut dari Anda? Berikan pendapat anda</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-form-container">
                <h3 class="form-title">Kirim Pesan</h3>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ url('/hubungi') }}" class="contact-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama *</label>
                        <input type="text" 
                               id="nama" 
                               name="nama" 
                               class="form-control" 
                               placeholder="Nama lengkap Anda"
                               value="{{ old('nama') }}"
                               required>
                    </div>
                    
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label" for="telepon">Nomor Telepon *</label>
                            <input type="tel" 
                                   id="telepon" 
                                   name="telepon" 
                                   class="form-control" 
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('telepon') }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="email">Email *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="email@example.com"
                                   value="{{ old('email') }}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="pesan">Pesan *</label>
                        <textarea id="pesan" 
                                  name="pesan" 
                                  class="form-control" 
                                  rows="6"
                                  placeholder="Tulis pesan Anda di sini..."
                                  required>{{ old('pesan') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-paper-plane"></i> KIRIM
                    </button>
                </form>
            </div>
            
            <div class="contact-info">
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Alamat</h4>
                        <p>Kaliurang, Kec. Tajur Halang<br>Kabupaten Bogor, Jawa Barat 16320</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Telepon</h4>
                        <p><a href="tel:02518553284">0251-8553284</a></p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Email</h4>
                        <p><a href="mailto:yayasaninsanteladan@yahoo.com">yayasaninsanteladan@yahoo.com</a></p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Jam Operasional</h4>
                        <p>Senin - Jumat: 07:00 - 15:00<br>Sabtu: 07:00 - 12:00<br>Minggu: Libur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
