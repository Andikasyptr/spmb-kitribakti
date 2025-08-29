<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GuruAbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $absenHariIni = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();
        $riwayat = Absensi::where('user_id', $user->id)->orderBy('tanggal', 'desc')->take(10)->get();

        return view('guru.absensi.index', compact('absenHariIni', 'riwayat'));
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        if (Absensi::where('user_id', $user->id)->where('tanggal', $today)->exists()) {
            return back()->with('info', 'Anda sudah absen masuk hari ini.');
        }

        // Simpan foto
        $fotoPath = null;
        if ($request->foto) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
            $filename = uniqid() . '_masuk.jpg';

            // Gunakan disk('public') agar masuk ke storage/app/public/absen
            Storage::disk('public')->put('absen/' . $filename, $imageData);
            $fotoPath = 'storage/absen/' . $filename;
        }

        Absensi::create([
            'user_id'       => $user->id,
            'tanggal'       => $today,
            'jam_masuk'     => now()->toTimeString(),
            'status_masuk'  => 'Hadir',
            'lokasi_masuk'  => $request->lokasi ?? null,
            'foto_masuk'    => $fotoPath,
            'dibuat_oleh'   => $user->id,
        ]);

        return back()->with('success', 'Berhasil absen masuk.');
    }

    public function absenPulang(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $absensi = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();
        if (!$absensi) {
            return back()->with('error', 'Belum absen masuk.');
        }
        if ($absensi->jam_pulang) {
            return back()->with('info', 'Sudah absen pulang.');
        }

        // Simpan foto
        $fotoPath = null;
        if ($request->foto) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
            $filename = uniqid() . '_pulang.jpg';

            // Gunakan disk('public') agar masuk ke storage/app/public/absen
            Storage::disk('public')->put('absen/' . $filename, $imageData);
            $fotoPath = 'storage/absen/' . $filename;
        }

        $absensi->update([
            'jam_pulang'    => now()->toTimeString(),
            'status_pulang' => 'Hadir',
            'lokasi_pulang' => $request->lokasi ?? null,
            'foto_pulang'   => $fotoPath,
        ]);

        return back()->with('success', 'Berhasil absen pulang.');
    }
}
