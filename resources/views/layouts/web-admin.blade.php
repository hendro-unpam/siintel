<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Web Admin') - Insan Teladan</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e7d32;
            --primary-hover: #1b5e20;
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
            background: linear-gradient(180deg, #1b5e20 0%, #2e7d32 100%);
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
            color: #81c784;
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
            color: #a5d6a7;
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
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
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
            box-shadow: 0 2px 8px rgba(46, 125, 50, 0.3);
            transition: all 0.2s ease;
            margin-right: 1rem;
        }

        .hamburger-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4);
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
            color: #a5d6a7;
            padding: 0.75rem 1rem 0.5rem;
            margin-top: 0.5rem;
        }

        .sidebar .nav-link {
            color: #c8e6c9;
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
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
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
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
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

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-card .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Table Card */
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

        .btn-primary {
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1b5e20, #4caf50);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -100%;
            }
            .sidebar.show {
                left: 0;
            }
            .sidebar-close {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
            .hamburger-btn {
                display: flex !important;
            }
        }

        @media (min-width: 992px) {
            .hamburger-btn {
                display: none;
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
                <i class="fas fa-globe brand-icon"></i>
                <span>Web Admin</span>
            </div>
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav>
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('webadmin.dashboard') }}" class="nav-link {{ request()->routeIs('webadmin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <div class="nav-section-title">Konten Website</div>
            <a href="{{ route('webadmin.berita.index') }}" class="nav-link {{ request()->routeIs('webadmin.berita.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i> Berita
            </a>
            <a href="{{ route('webadmin.prestasi.index') }}" class="nav-link {{ request()->routeIs('webadmin.prestasi.*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i> Prestasi
            </a>
            <a href="{{ route('webadmin.ekstrakurikuler.index') }}" class="nav-link {{ request()->routeIs('webadmin.ekstrakurikuler.*') ? 'active' : '' }}">
                <i class="fas fa-futbol"></i> Ekstrakurikuler
            </a>

            <div class="nav-section-title">Lainnya</div>
            <a href="{{ url('/') }}" class="nav-link" target="_blank">
                <i class="fas fa-external-link-alt"></i> Lihat Website
            </a>
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="hamburger-btn" id="hamburgerBtn">
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
                        {{ strtoupper(substr(Session::get('user_name', 'A'), 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block ms-2">
                        <span class="text-dark">{{ Session::get('user_name', 'Admin') }}</span>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Web Admin</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-2"></i>Lihat Website</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
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

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        hamburgerBtn?.addEventListener('click', () => {
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
        });

        sidebarClose?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        // Real-time clock
        function updateDateTime() {
            const now = new Date();
            const options = { 
                day: '2-digit', 
                month: 'long', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            const formatted = now.toLocaleDateString('id-ID', options);
            document.getElementById('currentDateTime').textContent = formatted;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
    @stack('scripts')
</body>
</html>
