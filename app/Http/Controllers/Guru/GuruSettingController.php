<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileGuru;

class GuruSettingController extends Controller
{
    public function index()
    {
        // Ambil data profil berdasarkan user yang sedang login
        $profile = ProfileGuru::where('user_id', Auth::id())->first();

        // Kirim data ke view
        return view('guru.settings.index', compact('profile'));
    }
}
