<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaSettingController extends Controller
{
    public function index()
    {
        // Ambil data profil siswa berdasarkan user yang sedang login
        $profile = Siswa::where('user_id', Auth::id())->first();

        // Kirim data ke view siswa.settings.index
        return view('siswa.settings.index', compact('profile'));
    }
}
