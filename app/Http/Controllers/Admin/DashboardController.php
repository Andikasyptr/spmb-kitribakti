<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =============================
        // TOTAL SISWA
        // =============================
        $totalSiswa = Siswa::count();

        // =============================
        // SUDAH BAYAR
        // (anggap 1 siswa minimal pernah bayar)
        // =============================
        $sudahBayar = Pembayaran::distinct('user_id')->count('user_id');

        // =============================
        // GRAFIK PENDAFTAR PER BULAN
        // ambil dari created_at tabel siswas
        // =============================
        $data = Siswa::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // siapkan 12 bulan
        $bulanLabel = [
            'Jan','Feb','Mar','Apr','Mei','Jun',
            'Jul','Agu','Sep','Okt','Nov','Des'
        ];

        $jumlahPendaftar = array_fill(0, 12, 0);

        foreach ($data as $d) {
            $jumlahPendaftar[$d->bulan - 1] = $d->total;
        }

        // =============================
        // SISWA PER JURUSAN
        // =============================
        $siswaPerJurusan = Siswa::select('jurusan', DB::raw('count(*) as total'))
            ->groupBy('jurusan')
            ->pluck('total', 'jurusan');

        // =============================
        // NOTIFIKASI PEMBAYARAN TERBARU
        // =============================
        $notifs = Pembayaran::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', [
            'totalSiswa' => $totalSiswa,
            'sudahBayar' => $sudahBayar,
            'bulan' => $bulanLabel,
            'jumlahPendaftar' => $jumlahPendaftar,
            'siswaPerJurusan' => $siswaPerJurusan,
            'notifs' => $notifs,
        ]);
    }


  

public function notifPembayaran()
{
    $notifs = Pembayaran::with('user')
        ->latest()
        ->take(5)
        ->get();

    return response()->json($notifs);
}

}
