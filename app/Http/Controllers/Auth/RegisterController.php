<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Menampilkan halaman form register
    public function showRegistrationForm()
    {
        return view('auth.register'); // pastikan file register.blade.php ada di resources/views/auth/
    }

    // Proses pendaftaran user
    public function register(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // ← tambahkan "confirmed"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Simpan user baru
        User::create([
            'name' => $request->name,
            'role' => 'siswa',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke login
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login!');
    }
}
