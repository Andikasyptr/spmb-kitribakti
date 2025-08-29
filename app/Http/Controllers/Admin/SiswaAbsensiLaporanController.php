<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaAbsensi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaAbsensiLaporanController extends Controller
{
    public function index(Request $request)
    {
        $nama = $request->input('nama');
        $bulan = $request->input('bulan', Carbon::now()->month);

        $startDate = Carbon::createFromDate(null, $bulan, 1)->startOfMonth()->startOfDay();
        $endDate = Carbon::createFromDate(null, $bulan, 1)->endOfMonth()->endOfDay();

        $absensis = SiswaAbsensi::with('user.siswa')
            ->whereHas('user', function ($query) use ($nama) {
                $query->where('role', 'siswa');
                if ($nama) {
                    $query->whereHas('siswa', function ($q) use ($nama) {
                        $q->where('nama', 'like', '%' . $nama . '%');
                    });
                }
            })
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status_masuk', 'Hadir')
            ->get();

        $users = $absensis->pluck('user')->filter()->unique('id');
        $data = [];

        foreach ($users as $index => $user) {
            $siswa = $user->siswa;
            if (!$siswa) continue;

            $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
            $row = [
                'no'   => $index + 1,
                'nama' => $siswa->nama ?? $user->name,
            ];

            $total = 0;

            foreach ($hariList as $hari) {
                $jumlahHadir = $absensis->filter(function ($a) use ($user, $hari) {
                    $namaHari = strtolower(Carbon::parse($a->tanggal)->locale('id')->dayName);
                    return $a->user_id == $user->id && $namaHari === $hari;
                })->count();

                $row[$hari] = $jumlahHadir;
                $total += $jumlahHadir;
            }

            $row['total'] = $total;
            $data[] = $row;
        }

        $bulanNama = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        return view('admin.absensi.laporan_siswa', compact('data', 'nama', 'bulan', 'bulanNama'));
    }

    public function exportPdf(Request $request)
    {
        // Sama persis dengan method index(), hanya beda return
        $nama = $request->input('nama');
        $bulan = $request->input('bulan', Carbon::now()->month);

        $startDate = Carbon::createFromDate(null, $bulan, 1)->startOfMonth()->startOfDay();
        $endDate = Carbon::createFromDate(null, $bulan, 1)->endOfMonth()->endOfDay();

        $absensis = SiswaAbsensi::with('user.siswa')
            ->whereHas('user', function ($query) use ($nama) {
                $query->where('role', 'siswa');
                if ($nama) {
                    $query->whereHas('siswa', function ($q) use ($nama) {
                        $q->where('nama', 'like', '%' . $nama . '%');
                    });
                }
            })
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status_masuk', 'Hadir')
            ->get();

        $users = $absensis->pluck('user')->filter()->unique('id');
        $data = [];

        foreach ($users as $index => $user) {
            $siswa = $user->siswa;
            if (!$siswa) continue;

            $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
            $row = [
                'no'   => $index + 1,
                'nama' => $siswa->nama ?? $user->name,
            ];

            $total = 0;

            foreach ($hariList as $hari) {
                $jumlahHadir = $absensis->filter(function ($a) use ($user, $hari) {
                    $namaHari = strtolower(Carbon::parse($a->tanggal)->locale('id')->dayName);
                    return $a->user_id == $user->id && $namaHari === $hari;
                })->count();

                $row[$hari] = $jumlahHadir;
                $total += $jumlahHadir;
            }

            $row['total'] = $total;
            $data[] = $row;
        }

        $bulanNama = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('admin.absensi.absensi_siswa_pdf', compact('data', 'bulanNama'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_absensi_siswa_' . strtolower($bulanNama) . '.pdf');
    }
}
