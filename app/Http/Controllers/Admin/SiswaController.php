<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $siswas = User::where('role', 'siswa')->get();
        return view('admin.akun_siswa.index', compact('siswas', 'profile'));
    }

    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_siswa.create', compact('profile'));
    }

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
            'role'     => 'siswa',
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $siswa = User::findOrFail($id);
        return view('admin.akun_siswa.edit', compact('siswa', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $siswa->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data akun siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil dihapus.');
    }
}
