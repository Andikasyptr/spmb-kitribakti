@extends('layouts.app')

@section('title', 'Detail Pegawai')
@include('components.sidebar-admin')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-semibold mb-4">Detail Pegawai</h2>

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><strong>Nama:</strong> {{ $pegawai->nama }}</div>
        <div class="break-words whitespace-normal"><strong>Email:</strong> {{ $pegawai->email }}</div>
        <div><strong>Nomor induk Kepegawaian:</strong> {{ $pegawai->nip ?? '-' }}</div>
        <div><strong>Jabatan:</strong> {{ $pegawai->jabatan ?? '-' }}</div>
        <div><strong>Tempat/Tgl Lahir:</strong> {{ $pegawai->ttl ?? '-' }}</div>
        <div><strong>Tahun Masuk:</strong> {{ $pegawai->tahun_masuk ?? '-' }}</div>
        <div><strong>Jenis Pegawai:</strong> {{ ucfirst($pegawai->jenis_pegawai) }}</div>
        <div><strong>No HP:</strong> {{ $pegawai->no_hp ?? '-' }}</div>
        <div class="col-span-2 break-words"><strong>Alamat:</strong> {{ $pegawai->alamat ?? '-' }}</div>
    </div>

    @if ($pegawai->jenis_pegawai == 'guru' && $pegawai->guruDetail)
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold text-lg mb-2">Data Guru</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><strong>Jumlah Kelas Mengajar:</strong> {{ $pegawai->guruDetail->jumlah_kelas_mengajar }}</div>
                <div><strong>Hari Mengajar:</strong> {{ $pegawai->guruDetail->jumlah_hari_mengajar }}</div>
                <div><strong>Jumlah Jam Mengajar:</strong> {{ $pegawai->jumlah_jam }}</div>
                <div><strong>Wali Kelas:</strong> {{ $pegawai->guruDetail->wali_kelas ? 'Ya' : 'Tidak' }}</div>
            </div>

            <div class="mt-3">
                <strong>Mata Pelajaran:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($pegawai->mapels as $mapel)
                        <li>{{ $mapel->mata_pelajaran }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

   <div class="mt-6 border-t pt-4">
    <h3 class="font-semibold text-lg mb-2">Pas Foto 3x4</h3>
    @if ($pegawai->foto)
        <div class="pl-5">
            <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Pas Foto Pegawai" class="w-32 h-40 object-cover border rounded shadow">
        </div>
    @else
        <p class="pl-5 text-sm">Tidak ada pas foto</p>
    @endif
</div>


    <div class="mt-6 border-t pt-4">
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

    <div class="mt-6 flex items-center gap-4">
    <a href="{{ route('pegawai.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>

    <form action="{{ route('admin.pegawai.edit', $pegawai->id) }}" method="GET">
        <button type="submit" class="bg-yellow-500 text-white px-10 py-2 rounded hover:bg-yellow-600 text-sm">
            Edit
        </button>
    </form>
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