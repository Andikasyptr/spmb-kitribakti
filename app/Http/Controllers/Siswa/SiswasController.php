<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class SiswasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa; // Relasi di model User ke tabel siswas

        return view('siswa.profile.indexprofile', compact('siswa'));
    }

    public function edit()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        $kelasList = Kelas::all();
        $jurusans = Jurusan::all(); // ambil data jurusan

        return view('siswa.profile.editprofile', compact('siswa', 'kelasList','jurusans'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,

            'nisn' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'no_kk' => 'nullable|string|max:20',
            'ttl' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|numeric',
            'nis' => 'nullable|string|max:50',
            'no_ijazah' => 'nullable|string|max:50',
            'kelas_id' => 'nullable|exists:kelas,id',
             'kode_kelas' => 'nullable|string|max:5',
            'jurusan' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',

            'nama_ayah' => 'nullable|string|max:255',
            'nik_ayah' => 'nullable|string|max:20',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',

            'nama_ibu' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|max:20',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ibu' => 'nullable|string|max:100',

            'alamat_orang_tua' => 'nullable|string|max:255',

            'file_skl' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update nama & email di tabel users
        $user->update([
            'name' => $validated['nama'],
            'email' => $validated['email'],
        ]);

        // Jika belum punya relasi siswa, buat baru
        if (!$siswa) {
            $siswa = new Siswa(['user_id' => $user->id]);
        }

        $siswa->fill($validated);

        // Handle upload file
        foreach ([
            'file_skl',
            'file_ijazah',
            'file_ktp_orang_tua',
            'file_kk',
            'file_foto'
        ] as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($siswa->$field && Storage::disk('public')->exists($siswa->$field)) {
                    Storage::disk('public')->delete($siswa->$field);
                }

                $path = $request->file($field)->store('spmb_files', 'public');
                $siswa->$field = $path;
            }
        }

        $siswa->save();

        return redirect()->route('profile.siswa')->with('success', 'Profil siswa berhasil diperbarui.');
    }
  

public function downloadTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'nama', 'email', 'nisn', 'nik', 'jenis_kelamin', 'agama', 'no_kk', 'ttl',
        'tahun_masuk', 'tahun_ajaran', 'kelas_id','kode_kelas', 'nis', 'no_ijazah',
        'nik_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'nik_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
        'jurusan', 'asal_sekolah', 'alamat', 'no_hp',
        'nama_ayah', 'nama_ibu', 'alamat_orang_tua'
    ];

    foreach ($headers as $i => $header) {
        $sheet->setCellValueByColumnAndRow($i + 1, 1, $header);
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'template_import_siswa.xlsx';

    // Output to browser
    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ]);
}
}
