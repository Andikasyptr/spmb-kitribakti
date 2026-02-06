<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use App\Models\SiswaPindahan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataSiswaController extends Controller
{
    public function index(Request $request)
{
    // Ambil semua input filter
    $tahun_ajaran = $request->input('tahun_ajaran');
    $kelas_id = $request->input('kelas_id');
    $jurusan = $request->input('jurusan');
    $kode_kelas = $request->input('kode_kelas');
    $search = $request->input('search'); // bisa nama atau nisn

    // 🔹 Mulai query dasar
    $query = Siswa::query();

    // 🔹 Filter berdasarkan tahun ajaran, kelas, jurusan, kode kelas
    if (!empty($tahun_ajaran)) {
        $query->where('tahun_ajaran', $tahun_ajaran);
    }

    if (!empty($kelas_id)) {
        $query->where('kelas_id', $kelas_id);
    }

    if (!empty($jurusan)) {
        $query->where('jurusan', $jurusan);
    }

    if (!empty($kode_kelas)) {
        $query->where('kode_kelas', $kode_kelas);
    }

    // 🔹 Filter pencarian berdasarkan nama atau NISN
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%");
        });
    }

    // 🔹 Ambil data siswa (paginate biar efisien)
    $siswas = $query->orderBy('nama', 'asc')->paginate(10);

    // 🔹 Data untuk dropdown di view
    $kelasList = Kelas::all();

    // 🔹 Buat list tahun ajaran dinamis (2025 - 2030 misalnya)
    $currentYear = now()->year;
    $tahunAjaranList = [];
    for ($year = 2025; $year <= $currentYear + 5; $year++) {
        $tahunAjaranList[] = $year . '/' . ($year + 1);
    }

    // 🔹 Ambil jurusan unik dari database siswa
    $jurusanList = Siswa::select('jurusan')->distinct()->pluck('jurusan');

    // 🔹 Kirim ke view
    return view('admin.datasiswa.index', compact(
        'siswas', 'kelasList', 'tahunAjaranList', 'jurusanList'
    ));
}

    public function create()
    {
        $jurusans = Jurusan::pluck('nama_jurusan', 'id');
        $kelasList = Kelas::all();
        $tahunAwal = 2020;
        $jumlahTahun = 10;
        return view('admin.datasiswa.create', compact('jurusans', 'kelasList', 'tahunAwal', 'jumlahTahun'));
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
            'file_skl' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'file_ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
            'file_nisn' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'file_akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',

        ]);

        
        foreach ([
                'file_skl',
                'file_ijazah',
                'file_ktp_orang_tua',
                'file_kk',
                'file_foto',
                'file_nisn',
                'file_akta'
            ] as $fileField) {

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
            'jenis_kelamin' => 'nullable|in:L,P,Belum diatur',
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
            'file_skl' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_foto' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_nisn' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_akta' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',

        ]);

        foreach ([
                'file_skl',
                'file_ijazah',
                'file_ktp_orang_tua',
                'file_kk',
                'file_foto',
                'file_nisn',
                'file_akta'
            ] as $fileField) {

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
        foreach ([
                'file_skl',
                'file_ijazah',
                'file_ktp_orang_tua',
                'file_kk',
                'file_foto',
                'file_nisn',
                'file_akta'
            ] as $fileField) {

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
        $html = view('admin.datasiswa.print', compact('siswa'))->render();
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('Data_Siswa_' . $siswa->nama . '.pdf');
    }

    public function storeArsip(Request $request)
    {
        $siswaId = $request->input('siswa_id');
        $siswa = Siswa::find($siswaId);
        if (!$siswa) return redirect()->back()->with('error', 'Siswa tidak ditemukan.');

        SiswaPindahan::create($siswa->toArray());
        $siswa->delete();
        return redirect()->route('datasiswa.index')->with('success', 'Data siswa berhasil dipindahkan ke arsip.');
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
            'tahun_masuk', 'tahun_ajaran', 'kelas_id', 'kode_kelas', 'nis', 'no_ijazah',
            'nik_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
            'nik_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
            'jurusan', 'asal_sekolah', 'alamat', 'status', 'no_hp',
            'nama_ayah', 'nama_ibu', 'alamat_orang_tua'
        ];

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
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true); // Ambil data Excel ke array

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                // Lewati header & baris kosong
                if ($index == 1 || empty($row['A'])) continue;

                // --- 🧹 Normalisasi email (hapus mailto:, spasi, jadikan huruf kecil)
                $email = trim(strtolower(str_replace('mailto:', '', $row['B'])));

                if (empty($email)) continue; // lewati jika tidak ada email

                // --- 🔍 Cari user berdasarkan email
                $user = \App\Models\User::whereRaw('LOWER(email) = ?', [$email])->first();

                // --- 👤 Jika belum ada user, buat otomatis
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => trim($row['A']),
                        'email' => $email,
                        'password' => bcrypt('12345678'), // password default
                        'role' => 'siswa', // pastikan ada kolom 'role' di tabel users
                    ]);
                }

                // --- 🚫 Cek apakah siswa dengan email ini sudah ada, agar tidak dobel
                $existingSiswa = \App\Models\Siswa::where('email', $email)->first();
                if ($existingSiswa) continue;

                // --- 💾 Simpan data siswa
                \App\Models\Siswa::create([
                    'user_id' => $user->id,
                    'nama' => trim($row['A']),
                    'email' => $email,
                    'nisn' => $row['C'] ?? null,
                    'nik' => $row['D'] ?? null,
                    'no_kk' => $row['E'] ?? null,
                    'ttl' => $row['F'] ?? null,
                    'tahun_masuk' => $row['G'] ?? null,
                    'tahun_ajaran' => $row['H'] ?? null,
                    'kelas_id' => $row['I'] ?? null,
                    'nis' => $row['J'] ?? null,
                    'no_ijazah' => $row['K'] ?? null,
                    'nik_ayah' => $row['L'] ?? null,
                    'pendidikan_ayah' => $row['M'] ?? null,
                    'pekerjaan_ayah' => $row['N'] ?? null,
                    'penghasilan_ayah' => $row['O'] ?? null,
                    'nik_ibu' => $row['P'] ?? null,
                    'pendidikan_ibu' => $row['Q'] ?? null,
                    'pekerjaan_ibu' => $row['R'] ?? null,
                    'penghasilan_ibu' => $row['S'] ?? null,
                    'jurusan' => $row['T'] ?? 'Belum diatur',
                    'asal_sekolah' => $row['U'] ?? null,
                    'alamat' => $row['V'] ?? null,
                    'no_hp' => $row['W'] ?? null,
                    'nama_ayah' => $row['X'] ?? null,
                    'nama_ibu' => $row['Y'] ?? null,
                    'alamat_orang_tua' => $row['Z'] ?? null,
                    'status' => $row['AA'] ?? 'siswa aktif',
                    'kode_kelas' => $row['AB'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('datasiswa.index')
                ->with('success', '✅ Data siswa berhasil diimport, akun otomatis dibuat & user_id terhubung.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }

            public function deleteAll()
    {
        try {

            // Hapus semua data siswa dan reset auto increment
            DB::table('siswas')->truncate();

            // Aktifkan kembali foreign key
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return redirect()->route('datasiswa.index')->with('success', 'Semua data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
{
    // 🔹 Ambil filter (sama persis dengan index)
    $tahun_ajaran = $request->input('tahun_ajaran');
    $kelas_id = $request->input('kelas_id');
    $jurusan = $request->input('jurusan');
    $kode_kelas = $request->input('kode_kelas');
    $search = $request->input('search');

    // 🔹 Query dasar
    $query = Siswa::query();

    if (!empty($tahun_ajaran)) {
        $query->where('tahun_ajaran', $tahun_ajaran);
    }

    if (!empty($kelas_id)) {
        $query->where('kelas_id', $kelas_id);
    }

    if (!empty($jurusan)) {
        $query->where('jurusan', $jurusan);
    }

    if (!empty($kode_kelas)) {
        $query->where('kode_kelas', $kode_kelas);
    }

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%");
        });
    }

    // 🔹 Ambil semua data (tanpa paginate)
    $siswas = $query->orderBy('nama')->get();

    // ================= EXCEL =================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Siswa');

    // 🔹 Header
    $headers = [
        'No', 'Nama', 'Email', 'NISN', 'NIK', 'JK', 'Agama',
        'TTL', 'Tahun Ajaran', 'Kelas', 'Kode Kelas', 'Jurusan',
        'Asal Sekolah', 'Alamat', 'No HP',
        'Nama Ayah', 'Pendidikan Ayah', 'Pekerjaan Ayah', 'Penghasilan Ayah',
        'Nama Ibu', 'Pendidikan Ibu', 'Pekerjaan Ibu', 'Penghasilan Ibu'
    ];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col.'1', $header);
        $sheet->getStyle($col.'1')->getFont()->setBold(true);
        $col++;
    }

    // 🔹 Data
    $row = 2;
    foreach ($siswas as $i => $siswa) {
        $sheet->setCellValue("A$row", $i + 1);
        $sheet->setCellValue("B$row", $siswa->nama);
        $sheet->setCellValue("C$row", $siswa->email);
        $sheet->setCellValue("D$row", $siswa->nisn);
        $sheet->setCellValue("E$row", $siswa->nik);
        $sheet->setCellValue("F$row", $siswa->jenis_kelamin);
        $sheet->setCellValue("G$row", $siswa->agama);
        $sheet->setCellValue("H$row", $siswa->ttl);
        $sheet->setCellValue("I$row", $siswa->tahun_ajaran);
        $sheet->setCellValue("J$row", optional($siswa->kelas)->nama_kelas);
        $sheet->setCellValue("K$row", $siswa->kode_kelas);
        $sheet->setCellValue("L$row", $siswa->jurusan);
        $sheet->setCellValue("M$row", $siswa->asal_sekolah);
        $sheet->setCellValue("N$row", $siswa->alamat);
        $sheet->setCellValue("O$row", $siswa->no_hp);

        $sheet->setCellValue("P$row", $siswa->nama_ayah);
        $sheet->setCellValue("Q$row", $siswa->pendidikan_ayah);
        $sheet->setCellValue("R$row", $siswa->pekerjaan_ayah);
        $sheet->setCellValue("S$row", $siswa->penghasilan_ayah);

        $sheet->setCellValue("T$row", $siswa->nama_ibu);
        $sheet->setCellValue("U$row", $siswa->pendidikan_ibu);
        $sheet->setCellValue("V$row", $siswa->pekerjaan_ibu);
        $sheet->setCellValue("W$row", $siswa->penghasilan_ibu);

        $row++;
    }

    // 🔹 Auto width
    foreach (range('A', 'W') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // 🔹 Download
    $writer = new Xlsx($spreadsheet);
    $filename = 'data_siswa_' . now()->format('Ymd_His') . '.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename);
}

    

}
