@extends('layouts.app')
@section('title', 'Daftar Ujian - smkhijaumuda')
@include('components.sidebar-siswa')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">📄 Daftar Ujian</h1>

    {{-- Tombol Panduan --}}
    <div class="mb-4">
        <button onclick="panduanUjian()" 
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow transition">
            📘 Panduan Ujian
        </button>
    </div>

    @if($exams->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($exams as $exam)
                <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $exam->title }}</h2>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Kelas {{ $exam->kelas }}</h4>
        <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $exam->description }}</p>

        {{-- Tambahan Start & End Time --}}
        <p class="text-xs mt-2">
            <span class="text-green-600 font-semibold">
                Mulai: {{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y H:i') }}
            </span><br>
            <span class="text-red-600 font-semibold">
                Selesai: {{ \Carbon\Carbon::parse($exam->end_time)->format('d M Y H:i') }}
            </span>
        </p>
    </div>
    <div class="flex justify-between items-center mt-2">
        <span class="text-xs text-gray-500">Durasi: {{ $exam->duration }} menit</span>

        @php
            $alreadyDone = \App\Models\StudentAnswer::where('student_id', auth()->id())
                ->where('exam_id', $exam->id)
                ->exists();

            $now = \Carbon\Carbon::now();
            $start = \Carbon\Carbon::parse($exam->start_time);
            $end = \Carbon\Carbon::parse($exam->end_time);
        @endphp

        @if($alreadyDone || $now->greaterThan($end))
            <button onclick="Swal.fire('Selesai', 'Ujian ini sudah berakhir atau sudah Anda kerjakan.', 'info')" 
                    class="bg-gray-400 text-white px-3 py-1 rounded-lg text-sm cursor-not-allowed">
                Selesai
            </button>
        @elseif($now->lessThan($start))
            <button onclick="Swal.fire('Belum Mulai', 'Ujian belum dimulai. Silakan tunggu waktu mulai.', 'warning')" 
                    class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm cursor-not-allowed">
                Belum Mulai
            </button>
        @else
            <button 
                onclick="mulaiUjian({{ $exam->id }})" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm transition">
                Mulai
            </button>
        @endif
    </div>
</div>

            @endforeach
        </div>

        <div class="mt-6">
            {{ $exams->links() }}
        </div>
    @else
        <div class="text-center text-gray-500 py-10">
            Belum ada ujian yang tersedia 📭
        </div>
    @endif

    {{-- Peta untuk verifikasi lokasi --}}
    <div id="mapContainer" class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Peta Lokasi Ujian</h3>
        <div id="map" class="w-full h-[360px] rounded shadow border relative"></div>
        <p id="koordinatTeks" class="mt-2 text-sm text-gray-700"></p>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const lokasiUjian = { lat: -6.262659, lng: 107.177224}; 
//-6.2531756,107.168489
// lat: -6.262659, lng: 107.177224 
const radiusMeter = 1000; 
let map = null;
let marker = null;

// Fungsi panduan ujian
function panduanUjian() {
    Swal.fire({
        title: '📘 Panduan Ujian',
        html: `
            <ul class="text-left">
                <li>1. Pastikan Anda berada di lokasi ujian.</li>
                <li>2. Periksa jaringan internet stabil.</li>
                <li>3. Pilih jawaban dengan teliti.</li>
                <li>4. Waktu ujian terbatas sesuai durasi.</li>
                <li>5. Jangan beralih dari halaman ujian, karena ujian akan otomatis selesai.</li>
            </ul>
        `,
        icon: 'info',
        confirmButtonText: 'Mengerti'
    });
}

// Fungsi hitung jarak
function hitungJarakMeter(lat1, lng1, lat2, lng2) {
    const R = 6371000;
    const φ1 = lat1 * Math.PI / 180;
    const φ2 = lat2 * Math.PI / 180;
    const Δφ = (lat2 - lat1) * Math.PI / 180;
    const Δλ = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(Δφ/2)**2 + Math.cos(φ1)*Math.cos(φ2)*Math.sin(Δλ/2)**2;
    return 2 * R * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

// Mulai ujian dengan spinner
function mulaiUjian(examId) {
    Swal.fire({
        title: 'Mengecek lokasi...',
        text: 'Mohon tunggu sebentar',
        didOpen: () => { Swal.showLoading() },
        allowOutsideClick: false
    });

    if (!navigator.geolocation) {
        Swal.fire('Error', 'Geolocation tidak didukung browser Anda!', 'error');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const jarak = hitungJarakMeter(lat, lng, lokasiUjian.lat, lokasiUjian.lng);

            if(jarak > radiusMeter) {
                Swal.fire({
                    icon: 'error',
                    title: 'Diluar Radius!',
                    html: `Anda berada <b>${jarak.toFixed(1)} meter</b> dari lokasi ujian.<br> Batas maksimal <b>${radiusMeter} meter</b>.`
                });
                return;
            }

            window.location.href = `/siswa/ujian/${examId}`;
        },
        function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mendapatkan Lokasi',
                text: error.message
            });
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

// Tampilkan peta (spinner saat load peta tetap dipakai)
function tampilkanPeta(lat, lng) {
    Swal.fire({
        title: 'Memuat peta...',
        didOpen: () => { Swal.showLoading() },
        allowOutsideClick: false
    });

    document.getElementById('koordinatTeks').textContent = `Lokasi Anda: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;

    if(!map) {
        map = L.map('map').setView([lat, lng], 17);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.circle([lokasiUjian.lat, lokasiUjian.lng], {
            color: 'green',
            fillColor: '#c6f6d5',
            fillOpacity: 0.3,
            radius: radiusMeter
        }).addTo(map).bindPopup("Batas Radius Ujian");
    } else {
        map.setView([lat, lng], 17);
    }

    if(marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Anda").openPopup();
    }

    setTimeout(() => {
        map.invalidateSize();
        Swal.close();
    }, 300);
}

// Load lokasi awal
document.addEventListener('DOMContentLoaded', function() {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                tampilkanPeta(position.coords.latitude, position.coords.longitude);
            },
            function(error) { console.warn("Gagal deteksi lokasi awal:", error.message); },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    // Tampilkan panduan otomatis saat halaman dibuka
    panduanUjian();
});
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    const mapContainer = document.getElementById('mapContainer');

    function toggleSidebar() {
        mobileSidebar.classList.toggle('-translate-x-full');
        sidebarBackdrop.classList.toggle('hidden');

        // hide peta saat sidebar terbuka
        if(!mobileSidebar.classList.contains('-translate-x-full')) {
            mapContainer.style.display = 'none';
        } else {
            mapContainer.style.display = 'block';
            setTimeout(() => map.invalidateSize(), 300);
        }
    }

    if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleSidebar);
    if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', toggleSidebar);
});
</script>
@endpush
