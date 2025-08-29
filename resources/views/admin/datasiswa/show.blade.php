@extends('layouts.app')
@section('title', 'Detail Siswa')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Detail Siswa</h2>

        <table class="w-full table-auto text-sm">
            <tbody class="divide-y divide-gray-200">
                <tr><td class="font-semibold py-2 w-1/3">Nama</td><td class="py-2">{{ $siswa->nama }}</td></tr>
                <tr><td class="font-semibold py-2">Email</td><td class="py-2">{{ $siswa->email }}</td></tr>
                <tr><td class="font-semibold py-2">NISN</td><td class="py-2">{{ $siswa->nisn }}</td></tr>
                <tr><td class="font-semibold py-2">NIK</td><td class="py-2">{{ $siswa->nik }}</td></tr>
                <tr><td class="font-semibold py-2">No. KK</td><td class="py-2">{{ $siswa->no_kk ?? '-' }}</td></tr>
                <tr><td class="font-semibold py-2">Tempat, Tanggal Lahir</td><td class="py-2">{{ $siswa->ttl ?? '-' }}</td></tr>
                <tr><td class="font-semibold py-2">Tahun Masuk</td><td class="py-2">{{ $siswa->tahun_masuk ?? '-' }}</td></tr>
                <tr>
                    <td class="font-semibold py-2">Tahun Ajaran</td>
                    <td class="py-2">{{ $siswa->tahun_ajaran ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="font-semibold py-2">Kelas</td>
                    <td class="py-2">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr><td class="font-semibold py-2">Jurusan</td><td class="py-2">{{ $siswa->jurusan ?? '-' }}</td></tr>
                <tr>
                    <td class="font-semibold py-2">Kode Kelas</td>
                    <td class="py-2">{{ $siswa->kode_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">NIS</td>
                    <td class="py-2">{{ $siswa->nis ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">No Ijazah</td>
                    <td class="py-2">{{ $siswa->no_ijazah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">NIK Ayah</td>
                    <td class="py-2">{{ $siswa->nik_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Pendidikan Terakhir Ayah</td>
                    <td class="py-2">{{ $siswa->pendidikan_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Pekerjaan Ayah</td>
                    <td class="py-2">{{ $siswa->pekerjaan_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Penghasilan Ayah</td>
                    <td class="py-2">{{ $siswa->penghasilan_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">NIK Ibu</td>
                    <td class="py-2">{{ $siswa->nik_ibu ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Pendidikan Terakhir Ibu</td>
                    <td class="py-2">{{ $siswa->pendidikan_ibu ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Pekerjaan Ibu</td>
                    <td class="py-2">{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Penghasilan Ibu</td>
                    <td class="py-2">{{ $siswa->penghasilan_ibu ?? '-' }}</td>
                </tr>

                
                <tr><td class="font-semibold py-2">Asal Sekolah</td><td class="py-2">{{ $siswa->asal_sekolah ?? '-' }}</td></tr>
                <tr><td class="font-semibold py-2">Alamat</td><td class="py-2">{{ $siswa->alamat ?? '-' }}</td></tr>
                <tr>
                    <td class="font-semibold">Status</td>
                    <td>{{ $siswa->status ?? '-' }}</td>
                </tr>
                <tr><td class="font-semibold py-2">No. HP</td><td class="py-2">{{ $siswa->no_hp ?? '-' }}</td></tr>
                <tr><td class="font-semibold py-2">Nama Ayah</td><td class="py-2">{{ $siswa->nama_ayah ?? '-' }}</td></tr>
                <tr><td class="font-semibold py-2">Nama Ibu</td><td class="py-2">{{ $siswa->nama_ibu ?? '-' }}</td></tr>
                <tr><td class="font-semibold py-2">Alamat Orang Tua</td><td class="py-2">{{ $siswa->alamat_orang_tua ?? '-' }}</td></tr>

                {{-- Dokumen --}}
                <tr>
                    <td class="font-semibold py-2">SKL</td>
                    <td class="py-2">
                        @if($siswa->file_skl)
                            <a href="{{ asset('storage/' . $siswa->file_skl) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                        @else
                            <span class="text-gray-500">Tidak tersedia</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Ijazah</td>
                    <td class="py-2">
                        @if($siswa->file_ijazah)
                            <a href="{{ asset('storage/' . $siswa->file_ijazah) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                        @else
                            <span class="text-gray-500">Tidak tersedia</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">KTP Orang Tua</td>
                    <td class="py-2">
                        @if($siswa->file_ktp_orang_tua)
                            <a href="{{ asset('storage/' . $siswa->file_ktp_orang_tua) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                        @else
                            <span class="text-gray-500">Tidak tersedia</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold py-2">Kartu Keluarga</td>
                    <td class="py-2">
                        @if($siswa->file_kk)
                            <a href="{{ asset('storage/' . $siswa->file_kk) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                        @else
                            <span class="text-gray-500">Tidak tersedia</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 align-top">Foto</td>
                    <td class="py-2">
                        @if($siswa->file_foto)
                            <img src="{{ asset('storage/' . $siswa->file_foto) }}" alt="Foto" class="h-32 rounded border">
                        @else
                            <span class="text-gray-500">Tidak tersedia</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ route('datasiswa.index') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            <a href="{{ route('datasiswa.edit', $siswa->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 ml-2">Edit</a>
            <a href="{{ route('datasiswa.print', $siswa->id) }}" target="_blank" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">Cetak PDF</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        
        function toggleSidebar() {
            mobileSidebar.classList.toggle('-translate-x-full');
            sidebarBackdrop.classList.toggle('hidden');
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', toggleSidebar);
        }
    });
</script>
@endpush