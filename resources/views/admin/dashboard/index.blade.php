@extends('layouts.app')
@section('title', 'Admin Dashboard - SMK Kitri Bakti')

@include('components.sidebar-admin')

@section('content')

{{-- PENTING: override warna text dari layout --}}
<div class="py-6 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- ================= HEADER ================= --}}
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-2xl shadow-lg p-5 sm:p-6">
            <h1 class="text-xl text-blue-800 sm:text-2xl font-bold">Dashboard Admin</h1>
            <p class="text-blue-800 sm:text-sm opacity-90">Sistem Penerimaan Murid Baru SMK Kitri Bakti</p>
        </div>


        {{-- ================= STATISTIK KARTU ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

            {{-- TOTAL SISWA --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm">Total Siswa</p>
                <h2 class="text-3xl font-bold text-blue-600 mt-1">
                    {{ $totalSiswa }}
                </h2>
            </div>

            {{-- SUDAH BAYAR --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-green-500">
                <p class="text-gray-500 text-sm">Sudah Bayar</p>
                <h2 class="text-3xl font-bold text-green-600 mt-1">
                    {{ $sudahBayar }}
                </h2>
            </div>

            {{-- BELUM BAYAR --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-red-500">
                <p class="text-gray-500 text-sm">Belum Bayar</p>
                <h2 class="text-3xl font-bold text-red-600 mt-1">
                    {{ $totalSiswa - $sudahBayar }}
                </h2>
            </div>

        </div>


        {{-- ================= GRAFIK PENDAFTAR ================= --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Grafik Pendaftar Setiap Bulan ({{ date('Y') }})
            </h2>

            <div class="w-full overflow-x-auto">
                <canvas id="chartPendaftar" class="min-w-[500px] h-[260px]"></canvas>
            </div>
        </div>


      
        {{-- ================= SISWA PER JURUSAN ================= --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Jumlah Siswa per Jurusan
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                @foreach ($siswaPerJurusan as $jurusan => $total)
                    <div class="bg-gray-50 border rounded-xl p-4">
                        <p class="text-gray-500 text-sm">
                            {{ $jurusan ?? '-' }}
                        </p>
                        <h3 class="text-2xl font-bold text-indigo-600">
                            {{ $total }}
                        </h3>
                    </div>
                @endforeach
            </div>
        </div>

          {{-- ================= NOTIFIKASI PEMBAYARAN ================= --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-700">
                    Notifikasi Pembayaran
                </h2>
                <span class="text-sm text-gray-400">
                    Auto refresh 10 detik
                </span>
            </div>

            <div id="notifPembayaran" class="space-y-3">

                @forelse($notifs as $notif)
                    <div class="border-l-4 border-green-500 bg-green-50 p-3 rounded-lg">
                        <b>{{ $notif->user->name ?? 'Siswa' }}</b>
                        telah mengirim bukti pembayaran
                        <div class="text-xs text-gray-500">
                            {{ $notif->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 text-sm">
                        Belum ada pembayaran terbaru
                    </div>
                @endforelse

            </div>
        </div>



        @include('components.footer')

    </div>
</div>


@endsection


{{-- ================= SCRIPTS ================= --}}
@push('scripts')

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const bulan = @json($bulan);
const jumlah = @json($jumlahPendaftar);

const ctx = document.getElementById('chartPendaftar').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: bulan,
        datasets: [{
            label: 'Jumlah Pendaftar',
            data: jumlah,
            borderWidth: 3,
            tension: 0.35,
            fill: true,
            backgroundColor: 'rgba(59,130,246,0.15)',
            borderColor: '#2563eb',
            pointBackgroundColor: '#2563eb',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio:false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});
</script>


{{-- NOTIFIKASI REALTIME TANPA MERUSAK SIDEBAR --}}
<script>
async function loadNotif(){

    const response = await fetch("{{ route('admin.notif.pembayaran') }}");
    const data = await response.json();

    let html = '';

    if(data.length === 0){
        html = `<div class="text-gray-400 text-sm">Belum ada pembayaran terbaru</div>`;
    }else{
        data.forEach(n => {
            html += `
                <div class="border-l-4 border-green-500 bg-green-50 p-3 rounded-lg">
                    <b>${n.user?.name ?? 'Siswa'}</b> telah mengirim bukti pembayaran
                    <div class="text-xs text-gray-500">
                        baru saja
                    </div>
                </div>
            `;
        });
    }

    document.getElementById('notifPembayaran').innerHTML = html;
}

setInterval(loadNotif, 10000);
</script>


{{-- MOBILE SIDEBAR FIX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');

    function toggleSidebar() {
        mobileSidebar.classList.toggle('-translate-x-full');
        sidebarBackdrop.classList.toggle('hidden');
    }

    if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleSidebar);
    if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', toggleSidebar);
});
</script>

@endpush
