<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Menampilkan daftar akun guru
    public function index()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $gurus = User::where('role', 'guru')->get();
        return view('admin.akun_guru.index', compact('gurus', 'profile'));
    }

    // Menampilkan form tambah akun guru
    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_guru.create', compact('profile'));
    }

    // Menyimpan akun guru baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil ditambahkan.');
    }

    // Menampilkan form edit guru
    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $guru = User::findOrFail($id);
        return view('admin.akun_guru.edit', compact('guru', 'profile'));
    }

    // Menyimpan update akun guru
    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $guru->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data akun guru berhasil diperbarui.');
    }

    // Menghapus akun guru
    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil dihapus.');
    }
}
