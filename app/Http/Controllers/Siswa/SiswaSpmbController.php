<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiswaSpmbController extends Controller
{
   public function create()
{
    $kelasList = Kelas::all(); 
    $jurusans = Jurusan::all();
    $user = Auth::user();
    $siswa = $user->siswa; // relasi dengan tabel siswa

    return view('siswa.spmb.form', compact('kelasList', 'jurusans', 'siswa'));
}


    // Simpan data pendaftaran SPMB
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'email' => 'required|email',
        'nisn' => 'nullable|string|max:10',
        'nik' => 'nullable|string|max:16',
        'jenis_kelamin' => 'nullable|in:L,P',
        'agama' => 'nullable|string',
        'no_kk' => 'nullable|string|max:16',
        'ttl' => 'nullable|string',
        'tahun_masuk' => 'nullable|numeric',
        'tahun_ajaran => nullable|string',
        'nis' => 'nullable|string',
        'no_ijazah' => 'nullable|string',
        'jurusan' => 'required|string',
        'asal_sekolah' => 'nullable|string',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:13',
        'nama_ayah' => 'nullable|string',
        'nik_ayah' => 'nullable|string|max:16',
        'pendidikan_ayah' => 'nullable|string',
        'pekerjaan_ayah' => 'nullable|string',
        'penghasilan_ayah' => 'nullable|string',
        'nama_ibu' => 'nullable|string',
        'nik_ibu' => 'nullable|string|max:16',
        'pendidikan_ibu' => 'nullable|string',
        'pekerjaan_ibu' => 'nullable|string',
        'penghasilan_ibu' => 'nullable|string',
        'alamat_orang_tua' => 'nullable|string',
         'kelas_id' => 'nullable|exists:kelas,id',
          'kode_kelas' => 'nullable|string|max:5',


        // Validasi file
        'file_skl' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
        'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
        'file_ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
        'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
        'file_foto' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $user = Auth::user();

    // Simpan nama dan email ke tabel users
    $user->update([
        'name' => $request->nama,
        'email' => $request->email,
    ]);

    // Handle file upload
    $file_skl = $request->file('file_skl') ? $request->file('file_skl')->store('dokumen/skl', 'public') : null;
    $file_ijazah = $request->file('file_ijazah') ? $request->file('file_ijazah')->store('dokumen/ijazah', 'public') : null;
    $file_ktp_orang_tua = $request->file('file_ktp_orang_tua') ? $request->file('file_ktp_orang_tua')->store('dokumen/ktp_ortu', 'public') : null;
    $file_kk = $request->file('file_kk') ? $request->file('file_kk')->store('dokumen/kk', 'public') : null;
    $file_foto = $request->file('file_foto') ? $request->file('file_foto')->store('dokumen/foto', 'public') : null;

    // Simpan atau update data siswa
    $user->siswa()->updateOrCreate(
        ['user_id' => $user->id],
        [   
            'nama' => $request->nama, // ← Tambahkan ini
            'email'=> $request->email,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'no_kk' => $request->no_kk,
            'ttl' => $request->ttl,
            'tahun_masuk' => $request->tahun_masuk,
            'tahun_ajaran' => $request->tahun_ajaran,
            'no_ijazah' => $request->no_ijazah,
            'kelas_id' => $request->kelas_id,
            'kode_kelas'=> $request->kode_kelas,
            'jurusan' => $request->jurusan,
            'asal_sekolah' => $request->asal_sekolah,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nama_ayah' => $request->nama_ayah,
            'nik_ayah' => $request->nik_ayah,
            'pendidikan_ayah' => $request->pendidikan_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'penghasilan_ayah' => $request->penghasilan_ayah,
            'nama_ibu' => $request->nama_ibu,
            'nik_ibu' => $request->nik_ibu,
            'pendidikan_ibu' => $request->pendidikan_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'penghasilan_ibu' => $request->penghasilan_ibu,
            'alamat_orang_tua' => $request->alamat_orang_tua,

            // Simpan nama file ke DB
            'file_skl' => $file_skl,
            'file_ijazah' => $file_ijazah,
            'file_ktp_orang_tua' => $file_ktp_orang_tua,
            'file_kk' => $file_kk,
            'file_foto' => $file_foto,
        ]
    );

    return redirect()->route('siswa.dashboard')->with('success', 'Data Anda berhasil disimpan.');
}

}
