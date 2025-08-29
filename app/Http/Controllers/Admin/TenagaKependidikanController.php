<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TenagaKependidikanController extends Controller
{
    public function index()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $staffs = User::where('role', 'staff')->get(); // role staff = tenaga kependidikan
        return view('admin.akun_tendik.index', compact('staffs', 'profile'));
    }

    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_tendik.create', compact('profile'));
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
            'role'     => 'staff', // role = staff (tenaga kependidikan)
        ]);

        return redirect()->route('admin.tendik.index')->with('success', 'Akun tenaga kependidikan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $staff = User::findOrFail($id);
        return view('admin.akun_tendik.edit', compact('staff', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $staff->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.tendik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();

        return redirect()->route('admin.tendik.index')->with('success', 'Akun berhasil dihapus.');
    }
}
