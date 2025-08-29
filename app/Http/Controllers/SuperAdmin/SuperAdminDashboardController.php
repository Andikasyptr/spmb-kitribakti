<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProfileAdmin;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil profil admin yang sedang login (jika digunakan di view)
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $superadmin =  Auth::user(); // asumsi user login sebagai superadmin

        // Hitung jumlah guru, siswa, dan tenaga kependidikan
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahTendik = User::where('role', 'staff')->count();

        // Jumlah siswa per kelas
        $siswaPerKelas = Siswa::with('kelas')->get()->groupBy(fn($siswa) => $siswa->kelas->nama_kelas ?? 'Belum diatur');

        // Jumlah siswa per jurusan
        $siswaPerJurusan = Siswa::all()->groupBy(fn($siswa) => $siswa->jurusan ?? 'Belum diatur');

        // Tampilkan view superadmin
        return view('superadmin.dashboard.index', compact(
            'jumlahGuru',
            'jumlahSiswa',
            'jumlahTendik',
            'siswaPerKelas',
            'siswaPerJurusan',
            'profile',
            'superadmin'
        ));
    }
}
