@extends('layouts.app')
@section('title', 'Profil Siswa')
@include('components.sidebar-siswa')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Profil Siswa</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(!$siswa)
        <div class="bg-yellow-100 border-l-4 border-yellow-600 text-yellow-800 p-4 rounded mb-6">
            <p class="font-semibold">Data profil siswa belum tersedia.</p>
            <p>Silakan lengkapi terlebih dahulu dengan klik tombol di bawah ini.</p>
        </div>

        <div class="text-right">
            <a href="{{ route('spmb.form') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lengkapi Profil</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
                <p><strong>Email:</strong> {{ $siswa->email }}</p>
                <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                <p><strong>NIK:</strong> {{ $siswa->nik }}</p>
                <p><strong>No KK:</strong> {{ $siswa->no_kk }}</p>
                <p><strong>TTL:</strong> {{ $siswa->ttl }}</p>
                <p><strong>Tahun Masuk:</strong> {{ $siswa->tahun_masuk }}</p>
                <p><strong>Kelas:</strong> {{ optional($siswa->kelas)->nama_kelas ?? 'Kelas diatur oleh admin' }}</p>
                <p><strong>Kode Kelas:</strong> {{ $siswa->kode_kelas ?? 'Belum diatur' }}</p>

                <p><strong>Jurusan:</strong> {{ $siswa->jurusan }}</p>
                <p><strong>Asal Sekolah:</strong> {{ $siswa->asal_sekolah }}</p>
                <p><strong>Alamat:</strong> {{ $siswa->alamat }}</p>
                <p><strong>No. HP:</strong> {{ $siswa->no_hp }}</p>
            </div>

            <div>
                <p><strong>Nama Ayah:</strong> {{ $siswa->nama_ayah }}</p>
                <p><strong>NIK Ayah:</strong> {{ $siswa->nik_ayah }}</p>
                <p><strong>Pendidikan Ayah:</strong> {{ $siswa->pendidikan_ayah }}</p>
                <p><strong>Pekerjaan Ayah:</strong> {{ $siswa->pekerjaan_ayah }}</p>
                <p><strong>Penghasilan Ayah:</strong> {{ $siswa->penghasilan_ayah }}</p>
                <p><strong>Nama Ibu:</strong> {{ $siswa->nama_ibu }}</p>
                <p><strong>NIK Ibu:</strong> {{ $siswa->nik_ibu }}</p>
                <p><strong>Pendidikan Ibu:</strong> {{ $siswa->pendidikan_ibu }}</p>
                <p><strong>Pekerjaan Ibu:</strong> {{ $siswa->pekerjaan_ibu }}</p>
                <p><strong>Penghasilan Ibu:</strong> {{ $siswa->penghasilan_ibu }}</p>
                <p><strong>Alamat Orang Tua:</strong> {{ $siswa->alamat_orang_tua }}</p>
            </div>
        </div>

        {{-- Dokumen --}}
        <div class="mt-6 border-t pt-4">
            <h3 class="text-lg font-semibold mb-2">Dokumen</h3>
            <ul class="list-disc list-inside text-sm text-gray-700">
                <li>SKL:
                    @if ($siswa->file_skl)
                        <a href="{{ asset('storage/' . $siswa->file_skl) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                    @else
                        <span class="text-red-600">Belum diunggah</span>
                    @endif
                </li>
                <li>Ijazah:
                    @if ($siswa->file_ijazah)
                        <a href="{{ asset('storage/' . $siswa->file_ijazah) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                    @else
                        <span class="text-red-600">Belum diunggah</span>
                    @endif
                </li>
                <li>KTP Orang Tua:
                    @if ($siswa->file_ktp_orang_tua)
                        <a href="{{ asset('storage/' . $siswa->file_ktp_orang_tua) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                    @else
                        <span class="text-red-600">Belum diunggah</span>
                    @endif
                </li>
                <li>Kartu Keluarga:
                    @if ($siswa->file_kk)
                        <a href="{{ asset('storage/' . $siswa->file_kk) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                    @else
                        <span class="text-red-600">Belum diunggah</span>
                    @endif
                </li>
                <li>Pas Foto:
                    @if ($siswa->file_foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $siswa->file_foto) }}" alt="Pas Foto" class="w-32 h-40 object-cover rounded border">
                        </div>
                    @else
                        <span class="text-red-600">Belum diunggah</span>
                    @endif
                </li>
            </ul>
        </div>

        <div class="mt-6 text-right">
            <a href="{{ route('profile.siswa.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit Profil</a>
        </div>
    @endif
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
