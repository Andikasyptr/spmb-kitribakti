<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    /**
     * Menampilkan halaman pembayaran siswa.
     */
    public function index()
    {
        $siswa = auth()->user()->siswa ?? null;

        // Cek apakah user sudah pernah upload bukti pembayaran
        $pembayaran = Pembayaran::where('user_id', auth()->id())->latest()->first();

        // Jika sudah upload, langsung tampilkan halaman cetak
        if ($pembayaran) {
            return view('siswa.spmb.pembayaran.cetak', compact('pembayaran'));
        }

        // Jika belum, tampilkan form upload pembayaran
        return view('siswa.spmb.pembayaran.index', compact('siswa'));
    }

    /**
     * Simpan bukti pembayaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:20',
             'nominal' => 'required|numeric|min:1000',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $path = $request->file('bukti_pembayaran')->store('pembayaran', 'public');

        Pembayaran::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'bukti_pembayaran' => $path,
             'nominal' => $request->nominal,
            'status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('siswa.pembayaran')
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    /**
     * Cetak bukti pembayaran sebagai PDF (opsional).
     */
   public function cetak($id)
{
    $pembayaran = Pembayaran::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('siswa.spmb.pembayaran.cetak-pdf', compact('pembayaran'))
        ->setPaper('a4', 'portrait');

    $filename = 'Bukti_Pembayaran_' . str_replace(' ', '_', $pembayaran->nama) . '.pdf';
    return $pdf->download($filename);
}

}
