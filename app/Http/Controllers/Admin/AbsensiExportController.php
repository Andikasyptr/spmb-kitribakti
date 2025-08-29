<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsensiExportController extends Controller
{
    public function export()
    {
        // Ambil semua data absensi yang sudah terhubung ke pegawai
        $absensis = Absensi::with('pegawai')->get();
        $pegawaiList = $absensis->pluck('pegawai')->unique('id');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Guru');
        $sheet->setCellValue('C1', 'Senin');
        $sheet->setCellValue('D1', 'Selasa');
        $sheet->setCellValue('E1', 'Rabu');
        $sheet->setCellValue('F1', 'Kamis');
        $sheet->setCellValue('G1', "Jum'at");
        $sheet->setCellValue('H1', 'Total');

        $row = 2;
        $no = 1;
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

        foreach ($pegawaiList as $pegawai) {
            if (!$pegawai) continue;

            $rowData = [
                'senin'  => 0,
                'selasa' => 0,
                'rabu'   => 0,
                'kamis'  => 0,
                'jumat'  => 0,
            ];

            $total = 0;

            foreach ($hariList as $hari) {
                $hadir = $absensis->where('pegawai_id', $pegawai->id)->where('hari', $hari)->count();
                $jam = $pegawai->$hari ?? 0;
                $rowData[$hari] = $hadir > 0 ? $jam : 0;
                $total += $rowData[$hari];
            }

            // Isi baris Excel
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $pegawai->nama);
            $sheet->setCellValue('C' . $row, $rowData['senin']);
            $sheet->setCellValue('D' . $row, $rowData['selasa']);
            $sheet->setCellValue('E' . $row, $rowData['rabu']);
            $sheet->setCellValue('F' . $row, $rowData['kamis']);
            $sheet->setCellValue('G' . $row, $rowData['jumat']);
            $sheet->setCellValue('H' . $row, $total);

            $row++;
        }

        $filename = 'laporan_absensi_guru.xlsx';
        $path = storage_path($filename);
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
