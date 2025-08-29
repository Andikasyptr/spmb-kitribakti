<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0 20px;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            padding: 6px 10px;
            vertical-align: top;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .section-title {
            margin-top: 25px;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #000;
        }
    </style>
</head>
<body>
    <h2>BIODATA SISWA</h2>
      <p class="section-title">Data Pribadi</p>
    <table>
        <tr><td class="label">Nama</td><td>{{ $siswa->nama }}</td></tr>
        <tr><td class="label">Email</td><td>{{ $siswa->email }}</td></tr>
        <tr><td class="label">NISN</td><td>{{ $siswa->nisn }}</td></tr>
        <tr><td class="label">NIK</td><td>{{ $siswa->nik }}</td></tr>
        <tr><td class="label">No. KK</td><td>{{ $siswa->no_kk ?? '-' }}</td></tr>
        <tr><td class="label">Tempat, Tanggal Lahir</td><td>{{ $siswa->ttl ?? '-' }}</td></tr>
        <tr><td class="label">Tahun Masuk</td><td>{{ $siswa->tahun_masuk ?? '-' }}</td></tr>
        <tr><td class="label">Tahun Ajaran</td><td>{{ $siswa->tahun_ajaran ?? '-' }}</td></tr>
        <tr><td class="label">Kelas</td><td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td></tr>
        <tr><td class="label">NIS</td><td>{{ $siswa->nis ?? '-' }}</td></tr>
        <tr><td class="label">No Ijazah</td><td>{{ $siswa->no_ijazah ?? '-' }}</td></tr>
         <tr><td class="label">Jurusan</td><td>{{ $siswa->jurusan ?? '-' }}</td></tr>
        <tr><td class="label">Asal Sekolah</td><td>{{ $siswa->asal_sekolah ?? '-' }}</td></tr>
        <tr><td class="label">Alamat</td><td>{{ $siswa->alamat ?? '-' }}</td></tr>
        <tr>
            <td class="label">Status</td>
            <td>{{ $siswa->status ?? '-' }}</td>
        </tr>

    </table>

    <p class="section-title">Data Orang Tua</p>
    <table>
        <tr><td class="label">Nama Ayah</td><td>{{ $siswa->nama_ayah ?? '-' }}</td></tr>
        <tr><td class="label">NIK Ayah</td><td>{{ $siswa->nik_ayah ?? '-' }}</td></tr>
        <tr><td class="label">Pendidikan Ayah</td><td>{{ $siswa->pendidikan_ayah ?? '-' }}</td></tr>
        <tr><td class="label">Pekerjaan Ayah</td><td>{{ $siswa->pekerjaan_ayah ?? '-' }}</td></tr>
        <tr><td class="label">Penghasilan Ayah</td><td>{{ $siswa->penghasilan_ayah ?? '-' }}</td></tr>

        <tr><td class="label">Nama Ibu</td><td>{{ $siswa->nama_ibu ?? '-' }}</td></tr>
        <tr><td class="label">NIK Ibu</td><td>{{ $siswa->nik_ibu ?? '-' }}</td></tr>
        <tr><td class="label">Pendidikan Ibu</td><td>{{ $siswa->pendidikan_ibu ?? '-' }}</td></tr>
        <tr><td class="label">Pekerjaan Ibu</td><td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td></tr>
        <tr><td class="label">Penghasilan Ibu</td><td>{{ $siswa->penghasilan_ibu ?? '-' }}</td></tr>
        <tr><td class="label">Alamat Orang Tua</td><td>{{ $siswa->alamat_orang_tua ?? '-' }}</td></tr>
        <tr><td class="label">No. HP</td><td>{{ $siswa->no_hp ?? '-' }}</td></tr>
    </table>
    <table>
    </table>
</body>
</html>
