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
use Illuminate\Support\Facades\Storage;

class TenagaKependidikanController extends Controller
{
    public function index()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $staffs = User::where('role', 'staff')->paginate(10);
        return view('admin.akun_tendik.index', compact('staffs', 'profile'));
    }

    public function create()
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        return view('admin.akun_tendik.create', compact('profile'));
    }

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
            'role'     => 'staff',
        ]);

        return redirect()->route('admin.tendik.index')->with('success', 'Akun tenaga kependidikan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        $staff = User::findOrFail($id);
        return view('admin.akun_tendik.edit', compact('staff', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $staff->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.tendik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();

        return redirect()->route('admin.tendik.index')->with('success', 'Akun berhasil dihapus.');
    }

    /**
     * Download template Excel tenaga kependidikan
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Tenaga Kependidikan');

        // Header kolom
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Password');

        // Contoh isi
        $sheet->setCellValue('A2', 'Contoh Nama');
        $sheet->setCellValue('B2', 'contoh@email.com');
        $sheet->setCellValue('C2', 'password123');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_tenaga_kependidikan.xlsx';
        $tempPath = storage_path('app/public/' . $fileName);

        $writer->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    /**
     * Import data tenaga kependidikan dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $count = 0;

        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // skip header
            if (empty($row[0]) || empty($row[1]) || empty($row[2])) continue;

            $exists = User::where('email', $row[1])->exists();
            if ($exists) continue;

            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => Hash::make($row[2]),
                'role' => 'staff',
            ]);

            $count++;
        }

        return redirect()->route('admin.tendik.index')->with('success', "$count akun tenaga kependidikan berhasil diimport.");
    }

    /**
     * Hapus semua akun tenaga kependidikan
     */
    public function deleteAll()
    {
        User::where('role', 'staff')->delete();
        return redirect()->route('admin.tendik.index')->with('success', 'Semua akun tenaga kependidikan telah dihapus.');
    }
}
