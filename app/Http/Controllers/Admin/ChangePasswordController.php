<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\ProfileAdmin;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Ambil profil berdasarkan user yang sedang login
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();

        // Kirim ke view
        return view('admin.ubahsandi', compact('profile'));
    }

    public function changePassword(Request $request)
    {
        // Validasi input dulu tanpa rule current_password
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

        // Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            // Kalau password lama salah, kembali dengan error
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Kalau benar, update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.ubahsandi')->with('success', 'Password berhasil diubah!');
    }
}
