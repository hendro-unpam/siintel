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
        .footer-text { text-align: center; margin-top: 1rem; color: #9ca3af; font-size: 0.8rem; }
        .alert { border-radius: 0.6rem; border: none; font-size: 0.9rem; }
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-icon">
                <i class="fas fa-graduation-cap"></i>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                {{-- School Selector --}}
                <div class="school-select-wrapper">
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

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </form>

            <p class="footer-text">&copy; {{ date('Y') }} Yayasan Insan Teladan</p>
        </div>
    </div>

    <script>
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
