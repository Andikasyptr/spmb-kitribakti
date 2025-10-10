<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;

class SiswaSettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan siswa (profil).
     */
    public function index()
    {
        // Ambil data profil siswa berdasarkan user yang sedang login
        $profile = Siswa::where('user_id', Auth::id())->first();

        // Kirim data ke view siswa.settings.index
        return view('siswa.settings.index', compact('profile'));
    }

    /**
     * Menampilkan form ubah sandi.
     */
    public function formUbahSandi()
    {
        return view('siswa.settings.ubahsandi');
    }

    /**
     * Proses ubah sandi siswa.
     */
    public function ubahSandi(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();
        
        // Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}
