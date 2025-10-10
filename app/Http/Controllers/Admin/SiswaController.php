<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();

        // Ambil keyword pencarian dari input GET
        $search = $request->input('search');

        // Query siswa + filter pencarian + pagination
        $siswas = User::where('role', 'siswa')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(20) // tampil 10 per halaman
            ->withQueryString(); // biar search tetap kebawa saat pindah halaman

        return view('admin.akun_siswa.index', compact('siswas', 'profile'));
    }


    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_siswa.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'exam_radius' => 'nullable|integer|min:10|max:10000',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
            'exam_radius' => $request->exam_radius, // boleh null
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $siswa = User::findOrFail($id);
        return view('admin.akun_siswa.edit', compact('siswa', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'exam_radius' => 'nullable|integer|min:10|max:10000',
        ]);

        $siswa->update([
            'name'  => $request->name,
            'email' => $request->email,
            'exam_radius' => $request->exam_radius, // null = pakai global
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data akun siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil dihapus.');
    }
    

    /* ============================================================
       ========== FITUR TAMBAHAN: IMPORT, TEMPLATE, DELETE ALL =====
       ============================================================ */

    // 📄 Download template Excel
    public function downloadTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom sesuai tabel users
    $sheet->setCellValue('A1', 'name');
    $sheet->setCellValue('B1', 'email');
    $sheet->setCellValue('C1', 'role');
    $sheet->setCellValue('D1', 'password');

    // Contoh data
    $sheet->setCellValue('A2', 'John Doe');
    $sheet->setCellValue('B2', 'john@example.com');
    $sheet->setCellValue('C2', 'siswa'); // default role
    $sheet->setCellValue('D2', '12345678');

    // Atur lebar kolom agar rapi
    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'template_import_akun siswa.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $fileName);
}

// ⬆️ Import file Excel
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls|max:2048',
    ]);

    try {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Lewati baris pertama (header)
        foreach (array_slice($rows, 1) as $row) {
            // Pastikan kolom name, email, dan password ada
            if (!empty($row[0]) && !empty($row[1]) && !empty($row[3])) {
                User::create([
                    'name'     => $row[0],
                    'email'    => $row[1],
                    'role'     => !empty($row[2]) ? $row[2] : 'siswa',
                    'password' => Hash::make($row[3]),
                ]);
            }
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diimport.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
    }
}


    // 🗑️ Hapus semua akun siswa
    public function deleteAll()
    {
        User::where('role', 'siswa')->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Semua akun siswa berhasil dihapus.');
    }
}