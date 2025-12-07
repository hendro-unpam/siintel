<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MultiAuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Session::has('user_id')) {
            return $this->redirectByRole(Session::get('user_role'));
        }

        $sekolahs = Sekolah::orderBy('nama')->get();
        return view('auth.login', compact('sekolahs'));
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $loginType = $request->login_type ?? 'app';
        
        // Web Admin login (requires sekolah_id)
        if ($loginType === 'web') {
            $request->validate([
                'sekolah_id' => 'required|exists:sekolahs,id',
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
            
            return $this->loginAsWebAdmin($request->username, $request->password, $request->sekolah_id);
        }
        
        // App login (requires sekolah_id)
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        $sekolahId = $request->sekolah_id;
        $username = $request->username;
        $password = $request->password;
        $role = $request->role;

        // Check based on selected role
        if ($role === 'admin') {
            return $this->loginAsAdmin($username, $password, $sekolahId);
        } elseif ($role === 'guru') {
            return $this->loginAsGuru($username, $password, $sekolahId);
        } elseif ($role === 'siswa') {
            return $this->loginAsSiswa($username, $password, $sekolahId);
        }

        return back()->withErrors([
            'username' => 'Role tidak valid!',
        ])->withInput($request->only('username', 'role', 'sekolah_id'));
    }

    /**
     * Login as Web Admin (per school)
     */
    protected function loginAsWebAdmin(string $username, string $password, int $sekolahId)
    {
        $user = User::where('sekolah_id', $sekolahId)
            ->where(function ($query) use ($username) {
                $query->where('email', $username)
                    ->orWhere('name', $username);
            })
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            
            $sekolah = Sekolah::find($sekolahId);
            
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', 'admin');
            Session::put('auth_type', 'user');
            Session::put('login_type', 'web');
            Session::put('sekolah_id', $sekolahId);
            Session::put('sekolah_nama', $sekolah->nama ?? 'Sekolah');
            Session::put('sekolah_logo', $sekolah->logo ?? null);

            return redirect()->route('webadmin.dashboard');
        }

        return back()->withErrors([
            'username' => 'Email atau Password salah untuk sekolah ini!',
        ])->withInput(request()->only('username', 'sekolah_id'));
    }

    /**
     * Login as Admin
     */
    protected function loginAsAdmin(string $username, string $password, int $sekolahId)
    {
        $user = User::where('sekolah_id', $sekolahId)
            ->where(function ($query) use ($username) {
                $query->where('email', $username)
                    ->orWhere('name', $username);
            })
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            
            $sekolah = Sekolah::find($sekolahId);
            
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', 'admin');
            Session::put('auth_type', 'user');
            Session::put('login_type', 'app');
            Session::put('sekolah_id', $sekolahId);
            Session::put('sekolah_nama', $sekolah->nama ?? 'Sekolah');
            Session::put('sekolah_logo', $sekolah->logo ?? null);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Email atau Password salah untuk sekolah ini!',
        ])->withInput(request()->only('username', 'role', 'sekolah_id'));
    }

    /**
     * Login as Guru
     */
    protected function loginAsGuru(string $username, string $password, int $sekolahId)
    {
        $guru = Guru::where('sekolah_id', $sekolahId)
            ->where('nip', $username)
            ->first();

        if ($guru && Hash::check($password, $guru->password)) {
            $sekolah = Sekolah::find($sekolahId);
            
            Session::put('user_id', $guru->id);
            Session::put('user_name', $guru->nama);
            Session::put('user_role', 'guru');
            Session::put('auth_type', 'guru');
            Session::put('guru_id', $guru->id);
            Session::put('sekolah_id', $sekolahId);
            Session::put('sekolah_nama', $sekolah->nama ?? 'Sekolah');
            Session::put('sekolah_logo', $sekolah->logo ?? null);

            return redirect('/guru-panel/dashboard');
        }

        return back()->withErrors([
            'username' => 'NIP atau Password salah untuk sekolah ini!',
        ])->withInput(request()->only('username', 'role', 'sekolah_id'));
    }

    /**
     * Login as Siswa
     */
    protected function loginAsSiswa(string $username, string $password, int $sekolahId)
    {
        $siswa = Siswa::where('sekolah_id', $sekolahId)
            ->where('nis', $username)
            ->first();

        if ($siswa && Hash::check($password, $siswa->password)) {
            $sekolah = Sekolah::find($sekolahId);
            
            Session::put('user_id', $siswa->id);
            Session::put('user_name', $siswa->nama);
            Session::put('user_role', 'siswa');
            Session::put('auth_type', 'siswa');
            Session::put('siswa_id', $siswa->id);
            Session::put('kelas_id', $siswa->kelas_id);
            Session::put('sekolah_id', $sekolahId);
            Session::put('sekolah_nama', $sekolah->nama ?? 'Sekolah');
            Session::put('sekolah_logo', $sekolah->logo ?? null);

            return redirect('/siswa-panel/dashboard');
        }

        return back()->withErrors([
            'username' => 'NIS atau Password salah untuk sekolah ini!',
        ])->withInput(request()->only('username', 'role', 'sekolah_id'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        Session::forget(['user_id', 'user_name', 'user_role', 'auth_type', 'login_type', 'guru_id', 'siswa_id', 'kelas_id', 'sekolah_id', 'sekolah_nama', 'sekolah_logo']);
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect user based on role
     */
    protected function redirectByRole(string $role)
    {
        // Check if user logged in as Web Admin
        if (Session::get('login_type') === 'web') {
            return redirect()->route('webadmin.dashboard');
        }
        
        return match ($role) {
            'admin' => redirect()->route('dashboard'),
            'guru' => redirect('/guru-panel/dashboard'),
            'siswa' => redirect('/siswa-panel/dashboard'),
            default => redirect()->route('login'),
        };
    }
}
