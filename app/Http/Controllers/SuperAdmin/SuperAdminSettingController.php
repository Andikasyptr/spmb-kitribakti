<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileAdmin;

class SuperAdminSettingController extends Controller
{
    public function index()
    {
        // Ambil data profil berdasarkan user yang sedang login
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();

        // Kirim data ke view superadmin.settings.index
        return view('superadmin.settings.index', compact('profile'));
    }
}
