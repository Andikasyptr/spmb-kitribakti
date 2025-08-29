<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\ProfileSuperAdmin; // gunakan model yang sudah diganti

class SuperAdminChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil profil berdasarkan user yang sedang login
        $profile = ProfileSuperAdmin::where('user_id', Auth::id())->first();

        // Kirim ke view superadmin
        return view('superadmin.ubahsandi', compact('profile'));
    }

    public function changePassword(Request $request)
    {
        // Validasi input
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
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('superadmin.ubahsandi')->with('success', 'Password berhasil diubah!');
    }
}
