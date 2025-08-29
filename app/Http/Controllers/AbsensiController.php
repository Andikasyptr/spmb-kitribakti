<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $nama = $request->nama;

        // Ambil absensi dengan relasi user dan pegawai (di dalam user)
        $absensis = Absensi::with(['user' => function($q) {
                $q->with('pegawai');
            }])
            ->whereMonth('tanggal', $bulan)
            ->whereHas('user', function ($q) use ($nama) {
                $q->where('role', 'guru');

                if ($nama) {
                    $q->whereHas('pegawai', function ($q2) use ($nama) {
                        $q2->where('nama', 'like', '%' . $nama . '%');
                    });
                }
            })
            ->get();

        $data = [];
        $no = 1;

        foreach ($absensis->groupBy('user_id') as $userId => $grouped) {
            $user = $grouped->first()->user;
            $pegawai = optional($user)->pegawai;

            $harian = ['senin' => 0, 'selasa' => 0, 'rabu' => 0, 'kamis' => 0, 'jumat' => 0];

            foreach ($grouped as $absen) {
                $hari = strtolower(Carbon::parse($absen->tanggal)->translatedFormat('l'));
                if (isset($harian[$hari])) {
                    $harian[$hari]++;
                }
            }

            $total = array_sum($harian);

            $data[] = [
                'no' => $no++,
                'nama' => $pegawai->nama ?? $user->name,
                'senin' => $harian['senin'],
                'selasa' => $harian['selasa'],
                'rabu' => $harian['rabu'],
                'kamis' => $harian['kamis'],
                'jumat' => $harian['jumat'],
                'total' => $total,
            ];
        }

        $bulanNama = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('admin.absensi.absensi_pdf', compact('data', 'bulanNama'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_absensi_guru_' . strtolower($bulanNama) . '.pdf');
    }
}
