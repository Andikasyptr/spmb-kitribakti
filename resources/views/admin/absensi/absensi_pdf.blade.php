<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Guru - {{ $bulanNama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Laporan Absensi Guru<br>Bulan {{ $bulanNama }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Senin</th>
                <th>Selasa</th>
                <th>Rabu</th>
                <th>Kamis</th>
                <th>Jumat</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row['no'] }}</td>
                    <td style="text-align: left;">{{ $row['nama'] }}</td>
                    <td>{{ $row['senin'] }}</td>
                    <td>{{ $row['selasa'] }}</td>
                    <td>{{ $row['rabu'] }}</td>
                    <td>{{ $row['kamis'] }}</td>
                    <td>{{ $row['jumat'] }}</td>
                    <td><strong>{{ $row['total'] }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
