<?php
// app/Http/Controllers/Admin/SettingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileAdmin;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data profil berdasarkan user yang sedang login
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();

        // Kirim data ke view
        return view('admin.settings.index', compact('profile'));
    }
}
