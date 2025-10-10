<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProfileAdmin;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data profil admin yang sedang login
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();

        // Ambil nilai radius dari tabel settings
       $radius = DB::table('settings')
        ->where('key', 'exam_radius')
        ->orderByDesc('updated_at')
        ->value('value') ?? 80; // default 100 meter

        // Kirim ke view
        return view('admin.settings.index', compact('profile', 'radius'));
    }

    // ✅ Method untuk update radius
    public function updateRadius(Request $request)
    {
        $request->validate([
            'radius' => 'required|integer|min:10|max:10000',
        ]);

        DB::table('settings')->updateOrInsert(
            ['key' => 'exam_radius'],
            [
                'value' => $request->radius,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Radius ujian berhasil diperbarui!');
    }
}
