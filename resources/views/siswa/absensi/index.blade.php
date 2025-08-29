@extends('layouts.app')
@section('title', 'Absensi Siswa - smkhijaumuda')
@include('components.sidebar-siswa')

@section('content')
{{-- Loading Overlay --}}
<div id="loadingOverlay" class="fixed inset-0 bg-white/80 backdrop-blur flex items-center justify-center z-50 hidden">
    <div class="text-center">
        <svg class="animate-spin h-10 w-10 text-indigo-600 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        <p class="text-gray-700 text-sm">Harap menunggu 10 sampai 15 detik</p>
    </div>
</div>

<div class="p-4 sm:p-6">
    {{-- Modal Panduan --}}
    <div id="panduanModal" class="fixed inset-0 bg-black/50 z-[9999] hidden items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-[90%] max-w-md p-6 relative">
            <button onclick="togglePanduanModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-3">Panduan Absensi</h2>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
                <li>Aktifkan GPS dan izinkan lokasi di browser.</li>
                <li>Izinkan akses kamera dari browser Anda.</li>
                <li>Klik tombol <strong>Absen Masuk</strong> saat datang ke sekolah.</li>
                <li>Ambil foto dan izinkan lokasi Anda dikirim.</li>
                <li>Saat pulang sekolah, klik <strong>Absen Pulang</strong>.</li>
                <li>Riwayat absen akan muncul di bawah.</li>
            </ul>
            <div class="mt-4 text-right">
                <button onclick="togglePanduanModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success')) <div class="text-green-600">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="text-red-600">{{ session('error') }}</div> @endif
    @if (session('info')) <div class="text-yellow-600">{{ session('info') }}</div> @endif

    <div class="mb-4 flex justify-between items-center flex-wrap gap-4">
        <h1 class="text-2xl font-bold">Absensi Hari Ini</h1>
        <button 
            type="button" 
            onclick="togglePanduanModal()" 
            class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded text-sm transition">
            Lihat Panduan
        </button>
    </div>

    {{-- Tombol Absen --}}
    <div class="mb-4">
        @if (!$absenHariIni)
            <form id="formMasuk" action="{{ route('siswa.absensi.masuk') }}" method="POST">
                @csrf
                <input type="hidden" name="lokasi">
                <input type="hidden" name="foto">
                <button type="button" onclick="isiFormAbsensi('formMasuk')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Absen Masuk
                </button>
            </form>
        @elseif (!$absenHariIni->jam_pulang)
            <p>Jam Masuk: {{ $absenHariIni->jam_masuk }}</p>
            <form id="formPulang" action="{{ route('siswa.absensi.pulang') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="lokasi">
                <input type="hidden" name="foto">
                <button type="button" onclick="isiFormAbsensi('formPulang')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Absen Pulang
                </button>
            </form>
        @endif
    </div>

    {{-- Kamera & Map --}}
    <div class="mt-4 flex flex-col lg:flex-row gap-6">
        {{-- Kamera --}}
        <div id="cameraContainer" class="hidden flex-1">
            <h3 class="text-lg font-semibold mb-2">Kamera Aktif</h3>
            <video id="cameraPreview" autoplay playsinline class="w-full max-w-full border rounded mb-2"></video>
            <button id="captureButton" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded w-full">
                Ambil Foto
            </button>
        </div>

        {{-- Peta --}}
        <div id="mapContainer" class="flex-1 hidden">
            <h3 class="text-lg font-semibold mb-2">Peta Lokasi</h3>
            <div id="map" class="w-full h-[360px] rounded shadow border"></div>
            <p id="koordinatTeks" class="mt-2 text-sm text-gray-700"></p>
        </div>

        {{-- Preview --}}
        <div id="previewContainer" class="hidden flex-1">
            <h3 class="text-lg font-semibold mb-2">Pratinjau Foto</h3>
            <img id="previewFoto" class="w-full max-w-full border rounded mb-2">
            <button id="submitButton" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded w-full">
                Konfirmasi & Kirim
            </button>
        </div>
    </div>


    {{-- Riwayat Absensi --}}
    <h2 class="text-xl font-semibold mt-6 mb-2">Riwayat Absensi</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border text-sm">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Masuk</th>
                    <th class="px-4 py-2">Pulang</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Foto Masuk</th>
                    <th class="px-4 py-2">Lokasi Masuk</th>
                    <th class="px-4 py-2">Foto Pulang</th>
                    <th class="px-4 py-2">Lokasi Pulang</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $index => $absen)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $absen->tanggal }}</td>
                    <td class="px-4 py-2">{{ $absen->jam_masuk ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $absen->jam_pulang ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $absen->status_masuk ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @if ($absen->foto_masuk)
                            <a href="{{ asset($absen->foto_masuk) }}" target="_blank" class="text-blue-600 underline">Lihat Foto</a>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if ($absen->lokasi_masuk)
                            @php [$lat, $lng] = explode(',', $absen->lokasi_masuk); @endphp
                            <a href="https://maps.google.com/?q={{ $lat }},{{ $lng }}" target="_blank" class="text-blue-600 underline">Lihat Lokasi</a>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if ($absen->foto_pulang)
                            <a href="{{ asset($absen->foto_pulang) }}" target="_blank" class="text-blue-600 underline">Lihat Foto</a>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if ($absen->lokasi_pulang)
                            @php [$lat, $lng] = explode(',', $absen->lokasi_pulang); @endphp
                            <a href="https://maps.google.com/?q={{ $lat }},{{ $lng }}" target="_blank" class="text-blue-600 underline">Lihat Lokasi</a>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-2">Belum ada data absensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Modal Wajib Lengkapi Profil --}}
@if (!auth()->user()->siswa)
    <style>
        body {
            overflow: hidden; /* biar tidak bisa discroll */
        }
        #elearning-content {
            filter: blur(6px);
            pointer-events: none; /* blok interaksi */
            user-select: none;
            transition: filter 0.3s ease;
        }
    </style>

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-transparent backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-600 max-w-lg p-6 relative z-50">
            <div class="flex items-center space-x-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Lengkapi Data Diri</h3>
            </div>
            <p class="mt-4 text-sm text-gray-600">
                Anda wajib melengkapi data diri terlebih dahulu untuk bisa mengakses fitur e-learning.
            </p>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('spmb.form') }}"
                   class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                    Lengkapi Profil
                </a>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// === SETTING KOORDINAT DAN RADIUS SEKOLAH ===
const lokasiSekolah = { lat: -6.262659, lng: 107.177224 };
// const lokasiSekolah = { lat: -6.2511066, lng: 107.1737123 };
const radiusMeter = 12; // 50 meter

let currentForm = null;
let currentStream = null;
let map = null;
let marker = null;

// Fungsi menghitung jarak dua titik koordinat (meter)
function hitungJarakMeter(lat1, lng1, lat2, lng2) {
    const R = 6371000; // Radius bumi dalam meter
    const φ1 = lat1 * Math.PI / 180;
    const φ2 = lat2 * Math.PI / 180;
    const Δφ = (lat2 - lat1) * Math.PI / 180;
    const Δλ = (lng2 - lng1) * Math.PI / 180;

    const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
              Math.cos(φ1) * Math.cos(φ2) *
              Math.sin(Δλ / 2) * Math.sin(Δλ / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // hasil dalam meter
}

// Fungsi utama saat klik Absen
async function isiFormAbsensi(formId) {
    currentForm = document.getElementById(formId);
    document.getElementById('loadingOverlay').classList.remove('hidden');

    if (!navigator.geolocation) {
        alert("Geolocation tidak didukung di browser ini.");
        document.getElementById('loadingOverlay').classList.add('hidden');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const jarak = hitungJarakMeter(lat, lng, lokasiSekolah.lat, lokasiSekolah.lng);

            if (jarak > radiusMeter) {
                alert(`❌ Anda berada di luar jangkauan lokasi (${jarak.toFixed(1)} meter). Batas maksimal adalah ${radiusMeter} meter. Tidak bisa melakukan absensi.`);
                document.getElementById('loadingOverlay').classList.add('hidden');
                return;
            }

            const lokasi = `${lat},${lng}`;
            currentForm.querySelector('[name=lokasi]').value = lokasi;

            tampilkanPeta(lat, lng);

            try {
                const video = document.getElementById('cameraPreview');
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                currentStream = stream;
                video.srcObject = stream;

                document.getElementById('cameraContainer').classList.remove('hidden');
                document.getElementById('previewContainer').classList.add('hidden');
                document.getElementById('loadingOverlay').classList.add('hidden');
            } catch (error) {
                alert("Tidak dapat mengakses kamera. Pastikan browser memiliki izin.");
                console.error("Kamera error:", error);
                document.getElementById('loadingOverlay').classList.add('hidden');
            }
        },
        function(error) {
            alert("Gagal mendapatkan lokasi: " + error.message);
            document.getElementById('loadingOverlay').classList.add('hidden');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

// Fungsi untuk tampilkan peta
function tampilkanPeta(lat, lng) {
    const container = document.getElementById('mapContainer');
    container.classList.remove('hidden');
    document.getElementById('koordinatTeks').textContent = `Lokasi Anda: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;

    if (!map) {
        map = L.map('map').setView([lat, lng], 17);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambah lingkaran batas radius di peta
        L.circle([lokasiSekolah.lat, lokasiSekolah.lng], {
            color: 'green',
            fillColor: '#c6f6d5',
            fillOpacity: 0.3,
            radius: radiusMeter
        }).addTo(map).bindPopup("Batas Radius Absensi");
    } else {
        map.setView([lat, lng], 17);
    }

    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Anda").openPopup();
    }

    setTimeout(() => map.invalidateSize(), 300);
}

// Saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', function () {
    // Deteksi lokasi awal untuk tampilkan peta
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                tampilkanPeta(lat, lng);
            },
            function(error) {
                console.warn("Gagal mendeteksi lokasi awal:", error.message);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    // Tombol ambil foto
    const captureBtn = document.getElementById('captureButton');
    if (captureBtn) {
        captureBtn.addEventListener('click', function () {
            const video = document.getElementById('cameraPreview');
            const canvas = document.createElement('canvas');
            canvas.width = 320;
            canvas.height = 240;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const fotoBase64 = canvas.toDataURL('image/jpeg');
            document.getElementById('previewFoto').src = fotoBase64;
            currentForm.querySelector('[name=foto]').value = fotoBase64;

            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }

            document.getElementById('previewContainer').classList.remove('hidden');
            document.getElementById('cameraContainer').classList.add('hidden');
        });
    }

    // Tombol submit
    const submitBtn = document.getElementById('submitButton');
    if (submitBtn) {
        submitBtn.addEventListener('click', function () {
            if (currentForm) {
                currentForm.submit();
            }
        });
    }
});

// Modal panduan toggle
function togglePanduanModal() {
    const modal = document.getElementById('panduanModal');
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
}
</script>
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


