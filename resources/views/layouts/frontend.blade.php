<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sekolah Insan Teladan - Menumbuhkan Generasi Penerus Bangsa Yang Cerdas, Peduli, Berkarakter Baik Berdasarkan Nilai-Nilai Kemanusiaan dan Menjadi Manusia Seutuhnya">
    <meta name="keywords" content="sekolah, pendidikan, TK, SD, SMP, Bogor, Insan Teladan">
    <meta name="author" content="Sekolah Insan Teladan">

    <title>@yield('title', 'Sekolah Insan Teladan')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo.png') }}">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <!-- Main Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <!-- Logo -->
                <div class="navbar-brand">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo Sekolah Insan Teladan" class="logo-img">
                        <div class="brand-text">
                            <span class="brand-title">The End Of Education</span>
                            <span class="brand-subtitle">Is Character</span>
                        </div>
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Navigation Menu -->
                <ul class="navbar-menu" id="navbarMenu">
                    <li class="nav-item">
                        <a href="{{ url('/tentang') }}" class="nav-link {{ request()->is('tentang') ? 'active' : '' }}">Tentang Kami</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">
                            Kesiswaan <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/kurikulum-tk') }}">Kurikulum TK</a></li>
                            <li><a href="{{ url('/kurikulum-sd') }}">Kurikulum SD</a></li>
                            <li><a href="{{ url('/kurikulum-smp') }}">Kurikulum SMP</a></li>
                            <li><a href="{{ url('/ekstrakurikuler') }}">Ekstrakulikuler</a></li>
                            <li><a href="{{ url('/tenaga-pendidik') }}">Tenaga Pendidik</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">
                            Prestasi <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/prestasi?kategori=akademik') }}">Akademik</a></li>
                            <li><a href="{{ url('/prestasi?kategori=non_akademik') }}">Non Akademik</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/berita') }}" class="nav-link {{ request()->is('berita*') ? 'active' : '' }}">Berita</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/hubungi') }}" class="nav-link {{ request()->is('hubungi') ? 'active' : '' }}">Hubungi Kami</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="margin-left: 10px; padding: 8px 20px;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer Start -->
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <div class="footer-grid">
                    <!-- About Section -->
                    <div class="footer-section">
                        <h3 class="footer-title">Tentang Kami</h3>
                        <p class="footer-text">
                            Sekolah Insan Teladan adalah sekolah swasta umum berbasis biaya yang didirikan pada tanggal 3 Agustus 2004. 
                            Kami berkomitmen menumbuhkan generasi yang cerdas, peduli, dan berkarakter baik.
                        </p>
                        <div class="footer-logo">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo" style="height: 50px;">
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-section">
                        <h3 class="footer-title">Link Cepat</h3>
                        <ul class="footer-links">
                            <li><a href="{{ url('/tentang') }}"><i class="fas fa-chevron-right"></i> Tentang Kami</a></li>
                            <li><a href="{{ url('/kurikulum-sd') }}"><i class="fas fa-chevron-right"></i> Kurikulum</a></li>
                            <li><a href="{{ url('/prestasi') }}"><i class="fas fa-chevron-right"></i> Prestasi</a></li>
                            <li><a href="{{ url('/berita') }}"><i class="fas fa-chevron-right"></i> Berita</a></li>
                            <li><a href="{{ url('/hubungi') }}"><i class="fas fa-chevron-right"></i> Hubungi Kami</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="footer-section">
                        <h3 class="footer-title">Kontak</h3>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Kaliurang, Kec. Tajur Halang<br>Kabupaten Bogor, Jawa Barat 16320</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <a href="tel:02518553284">0251-8553284</a>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:yayasaninsanteladan@yahoo.com">yayasaninsanteladan@yahoo.com</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Social Media & Info -->
                    <div class="footer-section">
                        <h3 class="footer-title">Ikuti Kami</h3>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.instagram.com/insanteladanschool" class="social-link" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                        <div class="footer-info">
                            <p><strong>Jam Operasional:</strong></p>
                            <p>Senin - Jumat: 07:00 - 15:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p>&copy; {{ date('Y') }} Sekolah Insan Teladan. All Rights Reserved.</p>
                    <p>Designed with IMAN AND TAQWA for Education</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- JavaScript Files -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/navbar.js') }}"></script>
</body>

</html>
