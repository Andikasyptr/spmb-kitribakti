<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamGuruPerHari;
use App\Models\GuruDetail;
use Carbon\Carbon;

class JamGuruPerHariController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jam_mengajar' => 'required|array',
            'jam_mengajar.senin' => 'integer|min:0',
            'jam_mengajar.selasa' => 'integer|min:0',
            'jam_mengajar.rabu' => 'integer|min:0',
            'jam_mengajar.kamis' => 'integer|min:0',
            'jam_mengajar.jumat' => 'integer|min:0',
        ]);

        $pegawaiId = $request->pegawai_id;
        $jam = $request->jam_mengajar;

        $now = Carbon::now();
        $mingguKe = $now->weekOfMonth;
        $tahun = $now->year;

        // Simpan data ke tabel jamguru_perhari
        JamGuruPerHari::create([
            'pegawai_id' => $pegawaiId,
            'senin' => $jam['senin'],
            'selasa' => $jam['selasa'],
            'rabu' => $jam['rabu'],
            'kamis' => $jam['kamis'],
            'jumat' => $jam['jumat'],
            'minggu_ke' => $mingguKe,
            'tahun' => $tahun,
        ]);

        // Hitung total seluruh jam dari semua minggu
        $totalJam = JamGuruPerHari::where('pegawai_id', $pegawaiId)
            ->selectRaw('SUM(senin + selasa + rabu + kamis + jumat) as total')
            ->value('total');

        // Update ke guru_details
        GuruDetail::updateOrCreate(
            ['pegawai_id' => $pegawaiId],
            ['jumlah_jam' => $totalJam]
        );

        return redirect()->back()->with('success', 'Jam mengajar per hari berhasil disimpan.');
    }
}
