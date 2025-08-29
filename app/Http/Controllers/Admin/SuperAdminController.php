<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ProfileAdmin;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    // Menampilkan daftar akun super-admin
    public function index()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $superAdmins = User::where('role', 'super-admin')->get();
        return view('admin.akun_superadmin.index', compact('superAdmins', 'profile'));
    }

    // Menampilkan form tambah super-admin
    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_superadmin.create', compact('profile'));
    }

    // Menyimpan data super-admin baru
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
            'role'     => 'super-admin',
        ]);

        return redirect()->route('admin.super-admin.index')->with('success', 'Akun super-admin berhasil ditambahkan.');
    }

    // Menampilkan form edit super-admin
    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $superAdmin = User::findOrFail($id);
        return view('admin.akun_superadmin.edit', compact('superAdmin', 'profile'));
    }

    // Menyimpan perubahan data super-admin
    public function update(Request $request, $id)
    {
        $superAdmin = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $superAdmin->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.super-admin.index')->with('success', 'Data super-admin berhasil diperbarui.');
    }

    // Menghapus data super-admin
    public function destroy($id)
    {
        $superAdmin = User::findOrFail($id);
        $superAdmin->delete();

        return redirect()->route('admin.super-admin.index')->with('success', 'Akun super-admin berhasil dihapus.');
    }
}
