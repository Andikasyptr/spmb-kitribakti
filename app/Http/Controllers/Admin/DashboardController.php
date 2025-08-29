<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileAdmin;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Ambil profil berdasarkan user yang sedang login
    $profile = ProfileAdmin::where('user_id', Auth::id())->first();

    $jumlahGuru = \App\Models\User::where('role', 'guru')->count();
    $jumlahSiswa = \App\Models\User::where('role', 'siswa')->count();
    $jumlahTendik = \App\Models\User::where('role', 'staff')->count();

    // Ambil data jumlah siswa per kelas (dari relasi ke tabel kelas)
    $siswaPerKelas = Siswa::with('kelas')->get()->groupBy(fn($siswa) => $siswa->kelas->nama_kelas ?? 'Belum diatur');

    // Ambil data jumlah siswa per jurusan (langsung dari kolom jurusan)
    $siswaPerJurusan = Siswa::get()->groupBy(fn($siswa) => $siswa->jurusan ?? 'Belum diatur');

    return view('admin.dashboard.index', compact(
        'jumlahGuru',
        'jumlahSiswa',
        'jumlahTendik',
        'siswaPerKelas',
        'siswaPerJurusan'
    ));
}

}
