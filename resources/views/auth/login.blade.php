<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiIntel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem;
            transition: background 0.5s ease;
        }
        body.web-mode {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #43a047 100%);
        }
        .login-container { width: 100%; max-width: 440px; }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        .login-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
            transition: all 0.3s ease;
        }
        .login-icon.web-mode {
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4);
        }
        .login-icon i { font-size: 1.75rem; color: #fff; }
        .login-title { text-align: center; margin-bottom: 0.25rem; font-size: 1.5rem; font-weight: 700; color: #1f2937; }
        .login-subtitle { text-align: center; color: #6b7280; margin-bottom: 1.5rem; font-size: 0.85rem; }
        .form-label { font-weight: 500; color: #374151; margin-bottom: 0.4rem; font-size: 0.9rem; }
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 0.6rem;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        .web-mode .form-control:focus, .web-mode .form-select:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
        }
        .input-group-text {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: 0.6rem 0 0 0.6rem;
            color: #6b7280;
        }
        .input-group .form-control { border-left: none; border-radius: 0 0.6rem 0.6rem 0; }
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 0.6rem;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.5);
            background: linear-gradient(135deg, #4338ca, #6d28d9);
        }
        .btn-login.web-mode {
            background: linear-gradient(135deg, #2e7d32, #43a047);
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.4);
        }
        .btn-login.web-mode:hover {
            background: linear-gradient(135deg, #1b5e20, #388e3c);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.5);
        }
        .footer-text { text-align: center; margin-top: 1rem; color: #9ca3af; font-size: 0.8rem; }
        .alert { border-radius: 0.6rem; border: none; font-size: 0.9rem; }
        
        /* Login Type Tabs */
        .login-type-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .login-type-tab {
            flex: 1;
            text-align: center;
            padding: 0.75rem;
            border-radius: 0.6rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
            color: #6b7280;
        }
        .login-type-tab:hover {
            border-color: #d1d5db;
        }
        .login-type-tab.active.app {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border-color: transparent;
        }
        .login-type-tab.active.web {
            background: linear-gradient(135deg, #2e7d32, #43a047);
            color: #fff;
            border-color: transparent;
        }
        .login-type-tab i { margin-right: 0.5rem; }

        .role-tabs {
            display: flex;
            background: #f3f4f6;
            border-radius: 0.6rem;
            padding: 0.2rem;
            margin-bottom: 1rem;
        }
        .role-tab {
            flex: 1;
            text-align: center;
            padding: 0.5rem 0.25rem;
            border-radius: 0.4rem;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            border: none;
            background: transparent;
        }
        .role-tab:hover { color: #4f46e5; }
        .role-tab.active {
            background: #fff;
            color: #4f46e5;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .role-tab i { display: block; font-size: 1rem; margin-bottom: 0.15rem; }
        .username-hint { font-size: 0.7rem; color: #9ca3af; margin-top: 0.2rem; }
        .school-select-wrapper {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 0.6rem;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #bae6fd;
        }
        .school-select-wrapper label {
            color: #0369a1;
            font-size: 0.8rem;
            margin-bottom: 0.4rem;
        }
        .school-select-wrapper .form-select {
            background: white;
            border-color: #7dd3fc;
        }
        .web-admin-note {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #86efac;
            border-radius: 0.6rem;
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .web-admin-note i { color: #22c55e; margin-bottom: 0.5rem; font-size: 1.5rem; }
        .web-admin-note p { color: #166534; margin: 0; font-size: 0.85rem; }
    </style>
</head>
<body id="loginBody">
    <div class="login-container">
        <div class="login-card">
            <div class="login-icon" id="loginIcon">
                <i class="fas fa-graduation-cap" id="loginIconImg"></i>
            </div>
            
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Sistem Informasi Sekolah Insan Teladan</p>

            @if($errors->any())
                <div class="alert alert-danger mb-3 py-2">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3 py-2">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Login Type Tabs --}}
            <div class="login-type-tabs">
                <div class="login-type-tab active app" data-type="app" onclick="selectLoginType('app')">
                    <i class="fas fa-graduation-cap"></i>App Sekolah
                </div>
                <div class="login-type-tab web" data-type="web" onclick="selectLoginType('web')">
                    <i class="fas fa-globe"></i>Web Admin
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="login_type" id="loginTypeInput" value="app">
                
                {{-- School Selector (for both App and Web) --}}
                <div class="school-select-wrapper" id="schoolSelectWrapper">
                    <label class="form-label mb-1"><i class="fas fa-school me-1"></i>Pilih Sekolah</label>
                    <select name="sekolah_id" id="sekolahSelect" class="form-select" required>
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                                {{ $sekolah->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- App Login Section (Role Selector) --}}
                <div id="appLoginSection">
                    {{-- Role Selector Tabs --}}
                    <div class="role-tabs">
                        <button type="button" class="role-tab active" data-role="admin" onclick="selectRole('admin')">
                            <i class="fas fa-user-shield"></i>Admin
                        </button>
                        <button type="button" class="role-tab" data-role="guru" onclick="selectRole('guru')">
                            <i class="fas fa-chalkboard-teacher"></i>Guru
                        </button>
                        <button type="button" class="role-tab" data-role="siswa" onclick="selectRole('siswa')">
                            <i class="fas fa-user-graduate"></i>Siswa
                        </button>
                    </div>
                    <input type="hidden" name="role" id="roleInput" value="admin">
                </div>

                {{-- Web Admin Note --}}
                <div id="webAdminNote" class="web-admin-note" style="display: none;">
                    <i class="fas fa-globe d-block"></i>
                    <p>Login sebagai Admin untuk mengelola konten website (Berita, Prestasi, Ekstrakurikuler)</p>
                </div>
                
                <div class="mb-2">
                    <label class="form-label" id="usernameLabel">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope" id="usernameIcon"></i></span>
                        <input type="text" name="username" id="usernameInput" class="form-control" placeholder="Masukkan email" value="{{ old('username') }}" required autofocus>
                    </div>
                    <div class="username-hint" id="usernameHint">Contoh: admin@siintel.com</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </form>

            <p class="footer-text">&copy; {{ date('Y') }} Yayasan Insan Teladan</p>
        </div>
    </div>

    <script>
        function selectLoginType(type) {
            document.getElementById('loginTypeInput').value = type;
            document.querySelectorAll('.login-type-tab').forEach(tab => tab.classList.remove('active'));
            document.querySelector(`[data-type="${type}"]`).classList.add('active');
            
            const body = document.getElementById('loginBody');
            const icon = document.getElementById('loginIcon');
            const iconImg = document.getElementById('loginIconImg');
            const btn = document.getElementById('loginBtn');
            const appSection = document.getElementById('appLoginSection');
            const webNote = document.getElementById('webAdminNote');
            
            if (type === 'web') {
                body.classList.add('web-mode');
                icon.classList.add('web-mode');
                btn.classList.add('web-mode');
                iconImg.className = 'fas fa-globe';
                appSection.style.display = 'none';
                webNote.style.display = 'block';
                // Set role to admin for web login
                document.getElementById('roleInput').value = 'admin';
                // Update labels for web admin
                document.getElementById('usernameLabel').textContent = 'Email Admin';
                document.getElementById('usernameInput').placeholder = 'Masukkan email admin';
                document.getElementById('usernameHint').textContent = 'Contoh: admin@siintel.com';
                document.getElementById('usernameIcon').className = 'fas fa-envelope';
            } else {
                body.classList.remove('web-mode');
                icon.classList.remove('web-mode');
                btn.classList.remove('web-mode');
                iconImg.className = 'fas fa-graduation-cap';
                appSection.style.display = 'block';
                webNote.style.display = 'none';
                // Reset to current role
                selectRole(document.getElementById('roleInput').value);
            }
        }

        function selectRole(role) {
            document.getElementById('roleInput').value = role;
            document.querySelectorAll('.role-tab').forEach(tab => tab.classList.remove('active'));
            document.querySelector(`[data-role="${role}"]`).classList.add('active');
            
            const label = document.getElementById('usernameLabel');
            const input = document.getElementById('usernameInput');
            const hint = document.getElementById('usernameHint');
            const icon = document.getElementById('usernameIcon');
            
            if (role === 'admin') {
                label.textContent = 'Email';
                input.placeholder = 'Masukkan email';
                hint.textContent = 'Contoh: admin@siintel.com';
                icon.className = 'fas fa-envelope';
            } else if (role === 'guru') {
                label.textContent = 'NIP';
                input.placeholder = 'Masukkan NIP';
                hint.textContent = 'Contoh: 19610506199';
                icon.className = 'fas fa-id-card';
            } else if (role === 'siswa') {
                label.textContent = 'NIS';
                input.placeholder = 'Masukkan NIS';
                hint.textContent = 'Contoh: 9965340897';
                icon.className = 'fas fa-id-badge';
            }
        }
    </script>
</body>
</html>
