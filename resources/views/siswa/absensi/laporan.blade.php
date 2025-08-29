@extends('layouts.app')
@include('components.sidebar-guru')
@section('title', 'laporan absensi guru')


@section('content')
    <div class="container">
        <h1 class="text-xl font-bold mb-4">Laporan Absensi Guru</h1>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Senin</th>
                    <th class="border px-4 py-2">Selasa</th>
                    <th class="border px-4 py-2">Rabu</th>
                    <th class="border px-4 py-2">Kamis</th>
                    <th class="border px-4 py-2">Jumat</th>
                    <th class="border px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td class="border px-4 py-2">{{ $row['no'] }}</td>
                        <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                        <td class="border px-4 py-2">{{ $row['senin'] }}</td>
                        <td class="border px-4 py-2">{{ $row['selasa'] }}</td>
                        <td class="border px-4 py-2">{{ $row['rabu'] }}</td>
                        <td class="border px-4 py-2">{{ $row['kamis'] }}</td>
                        <td class="border px-4 py-2">{{ $row['jumat'] }}</td>
                        <td class="border px-4 py-2">{{ $row['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
