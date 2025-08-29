<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Pegawai;

class GuruChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil data pegawai (guru) jika tersedia
        $profile = Pegawai::where('user_id', $user->id)->first();

        // Tampilkan form ubah sandi untuk guru
        return view('guru.ubahsandi', compact('profile'));
    }

    public function changePassword(Request $request)
    {
        // Validasi password
        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed'
            ],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('guru.ubahsandi')->with('success', 'Password berhasil diubah!');
    }
}
