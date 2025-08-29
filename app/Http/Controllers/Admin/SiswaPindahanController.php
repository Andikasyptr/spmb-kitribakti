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

    // Ubah data ke array, lalu ubah status sebelum disimpan ke tabel siswa
    $data = $siswaPindahan->toArray();
    $data['status'] = 'siswa aktif'; // ubah status jadi aktif

    // Simpan ke tabel siswa
    $siswaBaru = Siswa::create($data);

    // Hapus dari tabel siswa_pindahan
    $siswaPindahan->delete();

    return redirect()->back()->with('success', 'Siswa berhasil dipindahkan kembali ke data aktif.');
}

}
