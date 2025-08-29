<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuperAdminProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profileAdmin;

        return view('superadmin.profile.indexprofile', compact('profile'));
    }

    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profileAdmin;

        return view('superadmin.profile.editprofile', compact('profile'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profileAdmin;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        if (!$profile) {
            $profile = $user->profileAdmin()->create([
                'alamat' => $validated['alamat'] ?? null,
                'nik' => $validated['nik'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
        } else {
            $profile->alamat = $validated['alamat'] ?? $profile->alamat;
            $profile->nik = $validated['nik'] ?? $profile->nik;
            $profile->no_hp = $validated['no_hp'] ?? $profile->no_hp;
        }

        if ($request->hasFile('foto')) {
            if ($profile->foto) {
                Storage::disk('public')->delete($profile->foto);
            }

            $path = $request->file('foto')->store('profile_admin', 'public');
            $profile->foto = $path;
        }

        $profile->save();

        return redirect()->route('superadmin.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
