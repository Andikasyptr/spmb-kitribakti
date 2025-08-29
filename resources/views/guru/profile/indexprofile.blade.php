@extends('layouts.app')

@section('title', 'Guru Profile - Smkhijaumuda')
@include('components.sidebar-guru')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-semibold mb-4">Profile</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
        <div><strong>Nama:</strong> {{ auth()->user()->name }}</div>
        <div><strong>Email:</strong> {{ auth()->user()->email }}</div>

        @if ($pegawai)
            <div><strong>Nomor Induk Kepegawaian:</strong> {{ $pegawai->nip ?? '-' }}</div>
            <div><strong>Jabatan:</strong> {{ $pegawai->jabatan ?? '-' }}</div>
            <div><strong>Tempat/Tgl Lahir:</strong> {{ $pegawai->ttl ?? '-' }}</div>
            <div><strong>Tahun Masuk:</strong> {{ $pegawai->tahun_masuk ?? '-' }}</div>
            <div><strong>Jenis Pegawai:</strong> {{ ucfirst($pegawai->jenis_pegawai) }}</div>
            <div><strong>No HP:</strong> {{ $pegawai->no_hp ?? '-' }}</div>
            <div class="col-span-1 sm:col-span-2 break-words"><strong>Alamat:</strong> {{ $pegawai->alamat ?? '-' }}</div>
        @endif
    </div>

    @if ($pegawai && $pegawai->jenis_pegawai === 'guru')
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold text-lg mb-2">Data Guru</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><strong>Jumlah Kelas Mengajar:</strong> {{ $pegawai->jumlah_kelas_mengajar ?? '-' }}</div>
                <div><strong>Hari Mengajar:</strong> {{ $pegawai->guruDetail->jumlah_hari_mengajar ?? '-' }}</div>
                <div><strong>Jumlah Jam Mengajar:</strong> {{ $pegawai->guruDetail->jumlah_jam }}</div>
                <div><strong>Wali Kelas:</strong> {{ $pegawai->wali_kelas ? 'Ya' : 'Tidak' }}</div>
            </div>

            <div class="mt-3">
                <strong>Mata Pelajaran:</strong>
                <ul class="list-disc pl-5 text-sm">
                    @php
                        $mapelList = is_string($pegawai->mata_pelajaran)
                            ? explode(',', $pegawai->mata_pelajaran)
                            : (is_array($pegawai->mata_pelajaran) ? $pegawai->mata_pelajaran : []);
                    @endphp

                    @forelse ($mapelList as $mapel)
                        <li>{{ trim($mapel) }}</li>
                    @empty
                        <li>-</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @endif

    <div class="mt-6 border-t pt-4">
        <h3 class="font-semibold text-lg mb-2">Dokumen</h3>

        <div class="mt-4">
            <h3 class="font-semibold text-lg mb-2">Pas Foto 3x4</h3>
            @if ($pegawai->foto)
                <div class="pl-5">
                    <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Pas Foto Pegawai" class="w-32 h-40 object-cover border rounded shadow">
                </div>
            @else
                <p class="pl-5 text-sm">Tidak ada pas foto</p>
            @endif
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-lg mb-2">File SK</h3>
            <ul class="list-disc pl-5 text-sm">
                @forelse ($pegawai->sks as $sk)
                    <li><a href="{{ asset('storage/' . $sk->path_file) }}" target="_blank" class="text-blue-500 underline">{{ $sk->nama_file }}</a></li>
                @empty
                    <li>Tidak ada file SK</li>
                @endforelse
            </ul>
        </div>

        <div class="mt-4">
            <h3 class="font-semibold text-lg mb-2">Sertifikat</h3>
            <ul class="list-disc pl-5 text-sm">
                @forelse ($pegawai->sertifikats as $sertifikat)
                    <li><a href="{{ asset('storage/' . $sertifikat->path_file) }}" target="_blank" class="text-blue-500 underline">{{ $sertifikat->nama_sertifikat }}</a></li>
                @empty
                    <li>Tidak ada sertifikat</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-6 flex flex-col sm:flex-row items-center gap-4">
        <a href="{{ route('guru.profile.edit') }}" 
           class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 text-sm w-full sm:w-auto text-center">
            Lengkapi Profil
        </a>
        <!--<a href="{{ route('guru.settings') }}" class="text-sm text-blue-600 hover:underline w-full sm:w-auto text-center">&larr; Kembali</a>-->
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('mobile-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        if (toggle) toggle.addEventListener('click', toggleSidebar);
        if (backdrop) backdrop.addEventListener('click', toggleSidebar);
    });
</script>
@endpush
