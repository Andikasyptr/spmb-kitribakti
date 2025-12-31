<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Mail\PembayaranTerverifikasiMail;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query filter
        $nama = $request->input('nama');
        $nisn = $request->input('nisn');

        // Query pembayaran dengan relasi user -> siswa
        $pembayaran = Pembayaran::with(['user.siswa'])
            ->whereNotNull('bukti_pembayaran')
            ->when($nama, function ($query, $nama) {
                $query->whereHas('user.siswa', function ($q) use ($nama) {
                    $q->where('nama', 'like', "%{$nama}%");
                });
            })
            ->when($nisn, function ($query, $nisn) {
                $query->whereHas('user.siswa', function ($q) use ($nisn) {
                    $q->where('nisn', 'like', "%{$nisn}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.pembayaran.spmb.index', compact('pembayaran'));
    }

    // ✅ Fungsi verifikasi
        public function verifikasi($id)
    {
        $pembayaran = Pembayaran::with('user.siswa')->findOrFail($id);
    
        // Update status
        $pembayaran->update(['status' => 'Sudah Bayar']);
    
        // Data email
        $email = $pembayaran->user->email;
        $nama = $pembayaran->user->siswa->nama ?? $pembayaran->user->name;
    
        // Link menuju halaman riwayat pembayaran siswa
        $riwayatUrl = route('siswa.pembayaran');
    
        // Kirim email
        Mail::to($email)->send(new PembayaranTerverifikasiMail($nama, $riwayatUrl));
    
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi dan email telah dikirim 📧');
    }

}
