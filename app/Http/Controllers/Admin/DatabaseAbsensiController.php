<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\SiswaAbsensi;
use App\Http\Controllers\Admin\AbsensiExportController;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DatabaseAbsensiController extends Controller
{
    public function guru()
    {
        $absensis = Absensi::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'guru'))
            ->latest()
            ->paginate(30);

        return view('admin.absensi.guru', compact('absensis'));
    }

    public function tendik()
    {
        $absensis = Absensi::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'tendik'))
            ->latest()
            ->paginate(30);

        return view('admin.absensi.tendik', compact('absensis'));
    }

    public function siswa()
    {
        $absensis = SiswaAbsensi::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->latest()
            ->paginate(30);

        return view('admin.absensi.siswa', compact('absensis'));
    }

    public function laporan(Request $request)
    {
        $nama = $request->input('nama');
        $bulan = $request->input('bulan', Carbon::now()->month);

        $startDate = Carbon::createFromDate(null, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate(null, $bulan, 1)->endOfMonth();

        $absensis = Absensi::with('user.pegawai')
            ->whereHas('user', function ($query) use ($nama) {
                $query->where('role', 'guru');
                if ($nama) {
                    $query->whereHas('pegawai', function ($q) use ($nama) {
                        $q->where('nama', 'like', '%' . $nama . '%');
                    });
                }
            })
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
                'nama' => $pegawai->nama ?? $user->name,
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

        $bulanNama = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        return view('admin.absensi.laporan', compact('data', 'nama', 'bulan', 'bulanNama'));
    }

    public function laporanSiswa(Request $request)
    {
        $nama = $request->input('nama');
        $bulan = $request->input('bulan', Carbon::now()->month);

        $startDate = Carbon::createFromDate(null, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate(null, $bulan, 1)->endOfMonth();

        $absensis = SiswaAbsensi::with('user')
            ->whereHas('user', function ($query) use ($nama) {
                $query->where('role', 'siswa');
                if ($nama) {
                    $query->where('name', 'like', '%' . $nama . '%');
                }
            })
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $users = $absensis->pluck('user')->filter()->unique('id');
        $data = [];

        foreach ($users as $index => $user) {
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

                $row[$hari] = $hadir;
                $total += $hadir;
            }

            $row['total'] = $total;
            $data[] = $row;
        }

        $bulanNama = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        return view('admin.absensi.laporan_siswa', compact('data', 'nama', 'bulan', 'bulanNama'));
    }

    public function exportPdf(Request $request)
    {
        $nama = $request->input('nama');
        $bulan = $request->input('bulan', Carbon::now()->month);

        $startDate = Carbon::createFromDate(null, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate(null, $bulan, 1)->endOfMonth();

        $absensis = Absensi::with('user.pegawai')
            ->whereHas('user', function ($query) use ($nama) {
                $query->where('role', 'guru');
                if ($nama) {
                    $query->whereHas('pegawai', function ($q) use ($nama) {
                        $q->where('nama', 'like', '%' . $nama . '%');
                    });
                }
            })
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
                'nama' => $pegawai->nama ?? $user->name,
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

        $bulanNama = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('admin.absensi.absensi_pdf', compact('data', 'bulanNama'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_absensi_guru_' . strtolower($bulanNama) . '.pdf');
    }

    public function downloadExcel()
    {
        return app(AbsensiExportController::class)->export();
    }
}
