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

class GuruController extends Controller
{
    // Menampilkan daftar akun guru
    public function index()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $gurus = User::where('role', 'guru')->get();
        return view('admin.akun_guru.index', compact('gurus', 'profile'));
    }

    // Menampilkan form tambah akun guru
    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_guru.create', compact('profile'));
    }

    // Menyimpan akun guru baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil ditambahkan.');
    }

    // Menampilkan form edit guru
    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $guru = User::findOrFail($id);
        return view('admin.akun_guru.edit', compact('guru', 'profile'));
    }

    // Menyimpan update akun guru
    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $guru->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data akun guru berhasil diperbarui.');
    }

    // Menghapus akun guru
    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil dihapus.');
    }

    /* ===========================================================
       ============ FITUR TAMBAHAN: IMPORT, TEMPLATE, DELETE =====
       =========================================================== */

    // 📄 Download template Excel
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom sesuai tabel users
        $sheet->setCellValue('A1', 'name');
        $sheet->setCellValue('B1', 'email');
        $sheet->setCellValue('C1', 'password');
        $sheet->setCellValue('D1', 'role');

        // Contoh data
        $sheet->setCellValue('A2', 'Jane Doe');
        $sheet->setCellValue('B2', 'jane@example.com');
        $sheet->setCellValue('C2', '123456');
        $sheet->setCellValue('D2', 'guru');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_import_guru.xlsx';

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
                if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                    User::create([
                        'name'     => $row[0],
                        'email'    => $row[1],
                        'password' => Hash::make($row[2]),
                        'role'     => 'guru', // selalu guru
                    ]);
                }
            }

            return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    // 🗑️ Hapus semua akun guru
    public function deleteAll()
    {
        User::where('role', 'guru')->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Semua akun guru berhasil dihapus.');
    }
}
