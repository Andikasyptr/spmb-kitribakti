<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;
 use Carbon\Carbon;
 use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use App\Models\SiswaPindahan; // pastikan kamu sudah buat modelnya


class DataSiswaController extends Controller
{


public function index(Request $request)
{
    $tahun_ajaran = $request->tahun_ajaran;
    $kelas_id = $request->kelas_id;
    $jurusan = $request->jurusan;
    $kode_kelas = $request->kode_kelas;

    $query = Siswa::query();

    if ($tahun_ajaran) {
        $query->where('tahun_ajaran', $tahun_ajaran);
    }
    if ($kelas_id) {
        $query->where('kelas_id', $kelas_id);
    }
    if ($jurusan) {
        $query->where('jurusan', $jurusan);
    }
    if ($kode_kelas) {
        $query->where('kode_kelas', $kode_kelas);
    }

    $siswas = $query->latest()->get();

    $kelasList = Kelas::all();

    // Tahun Ajaran: dari 2025 sampai tahun sekarang + 5
    $currentYear = Carbon::now()->year;
    $tahunAjaranList = [];
    for ($year = 2025; $year <= $currentYear + 5; $year++) {
        $tahunAjaranList[] = $year . '/' . ($year + 1);
    }

    // Daftar jurusan unik untuk filter
    $jurusanList = Siswa::select('jurusan')->distinct()->pluck('jurusan');

    return view('admin.datasiswa.index', compact('siswas', 'kelasList', 'tahunAjaranList', 'jurusanList'));
}




    public function create()
    {
        $jurusans = Jurusan::pluck('nama_jurusan', 'id');
        $kelasList = Kelas::all();
         $tahunAwal = 2020; // atau sesuai awal tahun ajaran yang kamu inginkan
        $jumlahTahun = 10; // misalnya tampilkan 10 tahun ajaran ke depan
        return view('admin.datasiswa.create', compact('jurusans', 'kelasList','tahunAwal','jumlahTahun'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:siswas,email',
        'nis' => 'nullable|string|max:20',
        'nisn' => 'nullable|unique:siswas,nisn',
        'nik' => 'unique:siswas,nik',
        'jenis_kelamin' => 'required|in:L,P',
        'agama' => 'string|max:50',
        'no_kk' => 'nullable|string',
        'ttl' => 'nullable|string',
        'tahun_masuk' => 'nullable|integer',
        'tahun_ajaran' => 'nullable|string|max:20', // ✅ tambahkan ini
        'kelas_id' => 'nullable|exists:kelas,id',
        'kode_kelas' => 'nullable|string',
        'jurusan' => 'nullable|string',
        'asal_sekolah' => 'nullable|string',
        'alamat' => 'nullable|string',
        'status' => 'nullable|in:siswa aktif,siswa pindahan,keluar',
        'no_hp' => 'nullable|string',
        'no_ijazah' => 'nullable|string|max:50',
        'nama_ayah' => 'nullable|string',
        'nama_ibu' => 'nullable|string',
        'alamat_orang_tua' => 'nullable|string',
        'pendidikan_ayah' => 'nullable|string',
        'pendidikan_ibu' => 'nullable|string',
        'pekerjaan_ayah' => 'nullable|string',
        'pekerjaan_ibu' => 'nullable|string',
        'nik_ayah' => 'nullable|string',
        'nik_ibu' => 'nullable|string',
        'penghasilan_ayah' => 'nullable|string',
        'penghasilan_ibu' => 'nullable|string',
        'file_skl' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file_ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    foreach (['file_skl', 'file_ijazah', 'file_ktp_orang_tua', 'file_kk', 'file_foto'] as $fileField) {
        if ($request->hasFile($fileField)) {
            $validated[$fileField] = $request->file($fileField)->store("siswa/{$fileField}", 'public');
        }
    }

    Siswa::create($validated);

    return redirect()->route('datasiswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
}


    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.datasiswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $jurusans = Jurusan::pluck('nama_jurusan', 'id');
        $kelasList = Kelas::all();
        return view('admin.datasiswa.edit', compact('siswa', 'jurusans', 'kelasList'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:siswas,email,' . $siswa->id,
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|unique:siswas,nisn,' . $siswa->id,
            'nik' => 'unique:siswas,nik,' . $siswa->id,
            'jenis_kelamin' => 'required',
            'agama' => 'string',
            'no_kk' => 'nullable|string',
            'ttl' => 'nullable|string',
            'tahun_masuk' => 'nullable|integer',
            'tahun_ajaran' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
            'kode_kelas' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'asal_sekolah' => 'nullable|string',
            'alamat' => 'nullable|string',
            'status' => 'nullable|in:siswa aktif,siswa pindahan,keluar',
            'no_hp' => 'nullable|string',

            'no_ijazah' => 'nullable|string|max:50',
            'nama_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'alamat_orang_tua' => 'nullable|string',
            'pendidikan_ayah' => 'nullable|string',
            'pendidikan_ibu' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'nik_ayah' => 'nullable|string',
            'nik_ibu' => 'nullable|string',
            'penghasilan_ayah' => 'nullable|string',
            'penghasilan_ibu' => 'nullable|string',

            'file_skl' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        foreach (['file_skl', 'file_ijazah', 'file_ktp_orang_tua', 'file_kk', 'file_foto'] as $fileField) {
            if ($request->hasFile($fileField)) {
                if ($siswa->$fileField && Storage::disk('public')->exists($siswa->$fileField)) {
                    Storage::disk('public')->delete($siswa->$fileField);
                }
                $validated[$fileField] = $request->file($fileField)->store("siswa/{$fileField}", 'public');
            }
        }

        $siswa->update($validated);

        return redirect()->route('datasiswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        foreach (['file_skl', 'file_ijazah', 'file_ktp_orang_tua', 'file_kk', 'file_foto'] as $fileField) {
            if ($siswa->$fileField && Storage::disk('public')->exists($siswa->$fileField)) {
                Storage::disk('public')->delete($siswa->$fileField);
            }
        }

        $siswa->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

        public function print($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);

        // Render view ke HTML string
        $html = view('admin.datasiswa.print', compact('siswa'))->render();

        // Setup Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output PDF ke browser
        return $dompdf->stream('Data_Siswa_' . $siswa->nama . '.pdf');
    }


public function storeArsip(Request $request)
{
    $siswaId = $request->input('siswa_id');

    $siswa = Siswa::find($siswaId);

    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
    }

    // Salin data ke tabel siswa_pindahan
    SiswaPindahan::create([
        'nama' => $siswa->nama,
        'email' => $siswa->email,
        'nis' => $siswa->nis,
        'nisn' => $siswa->nisn,
        'nik' => $siswa->nik,
        'jenis_kelamin' => $siswa->jenis_kelamin,
        'agama' => $siswa->agama,
        'no_kk' => $siswa->no_kk,
        'ttl' => $siswa->ttl,
        'tahun_masuk' => $siswa->tahun_masuk,
        'tahun_ajaran' => $siswa->tahun_ajaran,
        'kelas_id' => $siswa->kelas_id,
        'kode_kelas' => $siswa->kode_kelas,
        'jurusan' => $siswa->jurusan,
        'asal_sekolah' => $siswa->asal_sekolah,
        'alamat' => $siswa->alamat,
        'status' => 'Keluar',
        'no_hp' => $siswa->no_hp,
        'no_ijazah' => $siswa->no_ijazah,
        'nama_ayah' => $siswa->nama_ayah,
        'nama_ibu' => $siswa->nama_ibu,
        'alamat_orang_tua' => $siswa->alamat_orang_tua,
        'pendidikan_ayah' => $siswa->pendidikan_ayah,
        'pendidikan_ibu' => $siswa->pendidikan_ibu,
        'pekerjaan_ayah' => $siswa->pekerjaan_ayah,
        'pekerjaan_ibu' => $siswa->pekerjaan_ibu,
        'nik_ayah' => $siswa->nik_ayah,
        'nik_ibu' => $siswa->nik_ibu,
        'penghasilan_ayah' => $siswa->penghasilan_ayah,
        'penghasilan_ibu' => $siswa->penghasilan_ibu,
        'file_skl' => $siswa->file_skl,
        'file_ijazah' => $siswa->file_ijazah,
        'file_ktp_orang_tua' => $siswa->file_ktp_orang_tua,
        'file_kk' => $siswa->file_kk,
        'file_foto' => $siswa->file_foto,
    ]);

    // Hapus dari tabel siswas (opsional)
    $siswa->delete();

    return redirect()->route('datasiswa.index')->with('success', 'Data siswa berhasil dipindahkan ke arsip (siswa keluar).');
}

public function move()
{
    $siswas = SiswaPindahan::with('kelas')->latest()->get();
    return view('admin.datasiswa.move', compact('siswas'));
}


public function downloadTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'nama', 'email', 'nisn', 'nik', 'no_kk', 'ttl',
        'tahun_masuk', 'tahun_ajaran', 'kelas_id','kode_kelas', 'nis', 'no_ijazah',
        'nik_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'nik_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
        'jurusan', 'asal_sekolah', 'alamat','status', 'no_hp',
        'nama_ayah', 'nama_ibu', 'alamat_orang_tua',
        'file_skl', 'file_ijazah', 'file_ktp_orang_tua', 'file_kk', 'file_foto'
    ];

    // Set Header
    foreach ($headers as $i => $header) {
        $column = Coordinate::stringFromColumnIndex($i + 1);
        $sheet->setCellValue($column . '1', $header);
    }


    $writer = new Xlsx($spreadsheet);
    $filename = 'template_import_siswa.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ]);
}


public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');
   

    try {
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true); // Ambil data sebagai array
        
        DB::beginTransaction();

        foreach ($rows as $index => $row) {
           if ($index == 1 || empty($row['A'])) continue;


           Siswa::create([
    'nama' => $row['A'],
    'email' => $row['B'],
    'nisn' => $row['C'],
    'nik' => $row['D'],
    'no_kk' => $row['E'],
    'ttl' => $row['F'],
    'tahun_masuk' => $row['G'],
    'tahun_ajaran' => $row['H'],
    'kelas_id' => $row['I'],
    'nis' => $row['J'],
    'no_ijazah' => $row['K'],
    'nik_ayah' => $row['L'],
    'pendidikan_ayah' => $row['M'],
    'pekerjaan_ayah' => $row['N'],
    'penghasilan_ayah' => $row['O'],
    'nik_ibu' => $row['P'],
    'pendidikan_ibu' => $row['Q'],
    'pekerjaan_ibu' => $row['R'],
    'penghasilan_ibu' => $row['S'],
    'jurusan' => $row['T'],
    'asal_sekolah' => $row['U'],
    'alamat' => $row['V'],
    'no_hp' => $row['W'],
    'nama_ayah' => $row['X'],
    'nama_ibu' => $row['Y'],
    'alamat_orang_tua' => $row['Z'],
    'status' => $row['AA'], // ✅ tambahkan baris ini
    'kode_kelas' => $row ['AB'],
]);

        }

        DB::commit();

        return redirect()->route('datasiswa.index')->with('success', 'Data siswa berhasil diimport.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
    }
}


}
