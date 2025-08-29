<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiGuruLaporanController extends Controller
{
    public function laporan()
{
    $startDate = Carbon::now()->subWeeks(4)->startOfDay();
    $endDate = Carbon::now()->endOfDay();

    $absensis = Absensi::with('user.pegawai')
        ->whereHas('user', fn($q) => $q->where('role', 'guru'))
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->get();

    $users = $absensis->pluck('user')->filter()->unique('id');
    $data = [];

    foreach ($users as $index => $user) {
        $pegawai = $user->pegawai;

        if (!$pegawai) continue;

        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        $row = [
            'no' => $index + 1,
            'nama' => $user->name,
        ];

        $total = 0;

        foreach ($hariList as $hari) {
            $hadir = $absensis->filter(function ($a) use ($user, $hari) {
                $namaHari = strtolower(Carbon::parse($a->tanggal)->locale('id')->dayName);
                return $a->user_id == $user->id && $namaHari === $hari;
            })->count();

            $jam = $pegawai->$hari ?? 0;
            $jamHari = $hadir > 0 ? $hadir * $jam : 0;

            $row[$hari] = $jamHari;
            $total += $jamHari;
        }

        $row['total'] = $total;
        $data[] = $row;
    }

    return view('guru.absensi.laporan', compact('data'));
}
}
