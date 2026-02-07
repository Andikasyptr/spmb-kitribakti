<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaPindahan;
use App\Models\Siswa;

class SiswaPindahanController extends Controller
{
    // Menampilkan detail data siswa pindahan
    public function show($id)
    {
        $siswa = SiswaPindahan::find($id);

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('admin.datasiswa.detail_pindahan', compact('siswa'));
    }

    // Menghapus data siswa pindahan
    public function destroy($id)
    {
        
        $siswa = SiswaPindahan::find($id);

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }
   public function kembalikan(Request $request)
{
    $siswaPindahan = SiswaPindahan::findOrFail($request->siswa_id);

    // Ambil data array
    $data = $siswaPindahan->toArray();

    // HAPUS KOLOM YANG BUKAN MILIK TABEL SISWA
    unset(
        $data['id'],
        $data['siswa_id'],
        $data['tanggal_keluar'],
        $data['alasan_keluar'],
        $data['sekolah_tujuan'],
        $data['file_surat_pindah'],
        $data['status_keluar'],
        $data['created_at'],
        $data['updated_at']
    );

    // simpan kembali ke siswa aktif
    Siswa::create($data);

    // hapus dari arsip
    $siswaPindahan->delete();

    return redirect()->back()->with('success', 'Siswa berhasil dikembalikan ke siswa aktif.');
}
};