<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiIntel') - Sistem Informasi Sekolah</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            padding: 1rem;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand .brand-info {
            display: flex;
            align-items: center;
        }

        .sidebar-brand i.brand-icon {
            font-size: 2rem;
            color: #818cf8;
            margin-right: 0.75rem;
        }

        .sidebar-brand span {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-close {
            background: transparent;
            border: none;
            color: #a5b4fc;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.25rem;
            display: none;
        }

        .sidebar-close:hover {
            color: #fff;
        }

        /* Hamburger Button */
        .hamburger-btn {
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            border: none;
            color: #fff;
            width: 42px;
            height: 42px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
            margin-right: 1rem;
        }

        .hamburger-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .nav-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #a5b4fc;
            padding: 0.75rem 1rem 0.5rem;
            margin-top: 0.5rem;
        }

        .sidebar .nav-link {
            color: #c7d2fe;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary-color), #818cf8);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Content Area */
        .content-area {
            padding: 1.5rem;
        }

        /* Cards */
        .stat-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .stat-card .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card.primary .stat-icon {
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            color: #fff;
        }

        .stat-card.success .stat-icon {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: #fff;
        }

        .stat-card.warning .stat-icon {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: #fff;
        }

        .stat-card.danger .stat-icon {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: #fff;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-card .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Table */
        .table-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-card .card-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
        }

        .table th {
            background: #f9fafb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #6b7280;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* Forms */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar.collapsed + .sidebar-overlay + .main-content,
        body.sidebar-collapsed .main-content {
            margin-left: 0;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-close {
                display: block;
            }
        }

        @media (min-width: 992px) {
            body.sidebar-collapsed .sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-collapsed .main-content {
                margin-left: 0;
            }

            body.sidebar-collapsed .sidebar-close {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-info">
                @if(session('sekolah_logo'))
                    <img src="{{ asset('storage/' . session('sekolah_logo')) }}" alt="Logo" class="brand-logo" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; margin-right: 0.75rem;">
                @else
                    <i class="fas fa-graduation-cap brand-icon"></i>
                @endif
                <div>
                    <span>{{ session('sekolah_nama') ? Str::limit(session('sekolah_nama'), 18) : 'SiIntel' }}</span>
                    @if(session('sekolah_nama'))
                        <small style="display: block; font-size: 0.65rem; color: #a5b4fc; margin-top: 2px;">{{ session('user_role', 'Admin') }}</small>
                    @endif
                </div>
            </div>
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="nav flex-column">
            @php $userRole = session('user_role', 'admin'); @endphp

            {{-- Admin Menu --}}
            @if($userRole === 'admin')
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <div class="nav-section-title">Master Data</div>
                
                <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Data Siswa
                </a>
                <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.*') && !request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i> Data Guru
                </a>
                <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                    <i class="fas fa-school"></i> Data Kelas
                </a>
                <a href="{{ route('mapel.index') }}" class="nav-link {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Mata Pelajaran
                </a>
                <a href="{{ route('pekerjaan.index') }}" class="nav-link {{ request()->routeIs('pekerjaan.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> Pekerjaan
                </a>

                <div class="nav-section-title">Akademik</div>

                <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
                </a>
                <a href="{{ route('absen.index') }}" class="nav-link {{ request()->routeIs('absen.index') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> Rekap Absensi
                </a>
                <a href="{{ route('absen.input') }}" class="nav-link {{ request()->routeIs('absen.input') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i> Input Absensi
                </a>
                <a href="{{ route('ujian.index') }}" class="nav-link {{ request()->routeIs('ujian.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Ujian & Nilai
                </a>

                <div class="nav-section-title">Laporan</div>

                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Laporan Absensi
                </a>

                <div class="nav-section-title">Pengaturan</div>

                <a href="{{ route('sekolah.index') }}" class="nav-link {{ request()->routeIs('sekolah.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Profil Sekolah
                </a>

            {{-- Guru Menu --}}
            @elseif($userRole === 'guru')
                <a href="/guru-panel/dashboard" class="nav-link {{ request()->is('guru-panel/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <div class="nav-section-title">Akademik</div>

                <a href="/guru-panel/jadwal" class="nav-link {{ request()->is('guru-panel/jadwal') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Jadwal Mengajar
                </a>
                <a href="/guru-panel/absen/input" class="nav-link {{ request()->is('guru-panel/absen/*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> Input Absensi
                </a>

            {{-- Siswa Menu --}}
            @elseif($userRole === 'siswa')
                <a href="/siswa-panel/dashboard" class="nav-link {{ request()->is('siswa-panel/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <div class="nav-section-title">Akademik</div>

                <a href="/siswa-panel/absensi" class="nav-link {{ request()->is('siswa-panel/absensi') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Riwayat Absensi
                </a>
                <a href="{{ route('siswa.nilai') }}" class="nav-link {{ request()->routeIs('siswa.nilai') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i> Nilai Saya
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="hamburger-btn" id="sidebarToggle" title="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            {{-- Center: School Name + DateTime --}}
            <div class="d-none d-md-flex align-items-center gap-4" style="font-size: 1.15rem; font-weight: 600; color: #374151;">
                <span>
                    <i class="fas fa-school me-1"></i>
                    {{ session('sekolah_nama', 'SiIntel') }}
                </span>
                <span>
                    <i class="fas fa-calendar-alt me-1"></i>
                    <span id="currentDateTime">{{ now()->translatedFormat('d F Y') }}</span>
                </span>
            </div>

            <div class="user-dropdown dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block ms-2">
                        <span class="text-dark">{{ session('user_name', 'User') }}</span>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">{{ ucfirst(session('user_role', 'admin')) }}</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            if (window.innerWidth < 992) {
                sidebar.classList.add('show');
                overlay.classList.add('show');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            if (window.innerWidth >= 992) {
                document.body.classList.remove('sidebar-collapsed');
            }
        }

        toggleBtn?.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }
        });

        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
        
        // Realtime clock
        function updateClock() {
            const options = { 
                day: '2-digit', 
                month: 'long', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const now = new Date().toLocaleDateString('id-ID', options);
            const clockEl = document.getElementById('currentDateTime');
            if (clockEl) clockEl.textContent = now;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    @stack('scripts')
</body>
</html>
