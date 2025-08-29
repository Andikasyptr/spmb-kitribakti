<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaAbsensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SiswaAbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $absenHariIni = SiswaAbsensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        $riwayat = SiswaAbsensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        return view('siswa.absensi.index', compact('absenHariIni', 'riwayat'));
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        if (SiswaAbsensi::where('user_id', $user->id)->where('tanggal', $today)->exists()) {
            return back()->with('info', 'Anda sudah absen masuk hari ini.');
        }

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->foto) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
            $filename = uniqid() . '_masuk.jpg';
            Storage::disk('public')->put('absen/' . $filename, $imageData);
            $fotoPath = 'storage/absen/' . $filename;
        }

        SiswaAbsensi::create([
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

        $absensi = SiswaAbsensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if (!$absensi) {
            return back()->with('error', 'Belum absen masuk.');
        }

        if ($absensi->jam_pulang) {
            return back()->with('info', 'Sudah absen pulang.');
        }

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->foto) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
            $filename = uniqid() . '_pulang.jpg';
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
