<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan ini benar
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input: password nullable (karena bisa bypass)
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable'
        ]);

        // Email yang diizinkan untuk login tanpa password
        $bypassUsers = [
            // 'admin@domain.com' => 'admin',
        ];

        // Login Bypass
        if (array_key_exists($request->email, $bypassUsers)) {
            $user = User::where('email', $request->email)->first();

            if ($user && $user->role === $bypassUsers[$request->email]) {
                Auth::login($user); // langsung login tanpa password

                return match($user->role) {
                    'super-admin' => redirect()->route('super.admin.dashboard'),
                    'admin' => redirect()->route('admin.dashboard'),
                    'guru' => redirect()->route('guru.dashboard'),
                    'staff' => redirect()->route('staff.dashboard'),
                    'siswa' => redirect()->route('siswa.dashboard'),
                    default => redirect()->route('login')->with('error', 'Role tidak dikenali.'),
                };
            }

            return back()->with('error', 'User tidak ditemukan atau role tidak cocok.');
        }

        // Login Normal (dengan cek password)
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $remember = $request->filled('remember');
            Auth::login($user, $remember);

            return match($user->role) {
                'super-admin' => redirect()->route('dashboard.index'),
                'admin' => redirect()->route('admin.dashboard'),
                'guru' => redirect()->route('guru.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                'siswa' => redirect()->route('siswa.dashboard'),
            
                default => redirect()->route('login')->with('error', 'Role tidak dikenali.'),
            };
        }

        return back()->withInput()->with('error', 'Email atau password salah.');
    }
        public function logout(Request $request)
        {
            Auth::logout(); // logout user yang sedang login
            $request->session()->invalidate(); // hapus semua session
            $request->session()->regenerateToken(); // regenerate token CSRF baru

            return redirect('/')->with('success', 'Anda berhasil logout.');
        }
}
