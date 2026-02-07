<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profileAdmin;

        return view('admin.profile.indexprofile', compact('profile'));
    }

    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profileAdmin;

        return view('admin.profile.editprofile', compact('profile'));
    }

    public function update(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $profile = $user->profileAdmin;

    // Validasi input termasuk nama dan email
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'alamat' => 'nullable|string',
        'nik' => 'nullable|string',
        'no_hp' => 'nullable|string',
        'foto' => 'nullable|image|max:2048', // max 2MB

    ]);

    // Update nama dan email di tabel users
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->save();

    // Update atau buat profileAdmin
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

    // Update foto jika ada
    if ($request->hasFile('foto')) {
        if ($profile->foto) {
            Storage::disk('public')->delete($profile->foto);
        }

        $path = $request->file('foto')->store('profile_admin', 'public');
        $profile->foto = $path;
    }

    $profile->save();

    return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui.');
}
}