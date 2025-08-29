<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>[x-cloak] { display: none !important; }</style>


    <!-- Logo Tab Browser -->
    <link rel="icon" href="{{ asset('/images/hm.png') }}" type="image/png">

    <!-- Tailwind CSS via Vite -->
    @vite('resources/css/app.css')

    <!-- Title -->
    <title>smkhijaumuda</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS (Animate on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  </head>

  <style>
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out both;
  }
</style>

{{-- spmb --}}
<style>
  @keyframes fadeInUp {
    0% {
      opacity: 0;
      transform: translateY(30px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
  }

  @keyframes fadeOutDown {
    0% {
      opacity: 1;
      transform: translateY(0);
    }
    100% {
      opacity: 0;
      transform: translateY(30px);
    }
  }

  .animate-fade-out-down {
    animation: fadeOutDown 0.8s ease-in forwards;
  }

  /* popup */
  @keyframes fade-in {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}
  
</style>



  <!-- NAVIGATION BAR -->
<!-- Perbaikan di <body> -->
<body class="h-full animate-fade-in" x-data="{ sidebarOpen: false }">

<!-- NAVIGATION BAR -->
<!-- NAVBAR -->
<nav class="bg-[#24555e] text-white px-6 py-4 flex justify-between items-center shadow-md z-50 relative">
    <!-- Logo -->
    <div class="flex items-center">
        <a href="{{ url('/') }}" class="-m-1.5 p-1.5">
            <span class="sr-only">SMK Hijau Muda</span>
            <img class="h-12 w-auto logo-hover" src="images/hm.png" alt="">
        </a>
    </div>

    <!-- Hamburger (Mobile Only) -->
    <div class="md:hidden">
        <button @click="sidebarOpen = true" class="text-white focus:outline-none">
            <!-- Hamburger Icon -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Menu Desktop -->
    <ul class="hidden md:flex gap-6 font-medium text-sm">
        <a href="{{ url ('/') }}" class="block py-2 hover:text-yellow-400 transition">Beranda</a>
        <a href="#" class="block py-2 hover:text-yellow-300 transition">Rekomendasi Sekolah</a>
        <a href="#" class="block py-2 hover:text-yellow-300 transition">Informasi SPMB</a>
        <a href="#" class="block py-2 hover:text-yellow-300 transition">Informasi Pendukung</a>

    </ul>

    <!-- Login Button Desktop -->
    <div class="hidden md:block">
        <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white text-sm font-semibold transition">
            Masuk/Login
        </a>
    </div>
</nav>

<!-- SIDEBAR MOBILE -->
<div x-show="sidebarOpen" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     class="fixed inset-0 z-50 flex md:hidden"
     @keydown.escape.window="sidebarOpen = false">

    <!-- Sidebar Content -->
    <div class="bg-[#24555e] w-64 p-6 space-y-4 text-white shadow-lg transform">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Menu</h2>
            <!-- Tombol Silang -->
            <button @click="sidebarOpen = false">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <a href="{{ url ('/') }}" class="block py-2 hover:text-yellow-400 transition">Beranda</a>
        <a href="#" class="block py-2 hover:text-yellow-300 transition">Rekomendasi Sekolah</a>
        <a href="#" class="block py-2 hover:text-yellow-300 transition">Informasi SPMB</a>
        <a href="#" class="block py-2 hover:text-yellow-300 transition">Informasi Pendukung</a>
        <a href="{{ route('login') }}" class="mt-4 inline-block w-full text-center bg-green-500 hover:bg-green-600 px-4 py-2 rounded font-semibold transition">
            Masuk/Login
        </a>
    </div>
    <!-- Overlay -->
    <div class="flex-1 bg-black bg-opacity-50" @click="sidebarOpen = false"></div>
</div>

<!-- HERO SECTION -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-6 bg-[#f5faff] animate-fade-in-up">
  <!-- Kartu Hijau -->
  <div class="bg-green-400 text-white p-6 rounded-lg shadow-md transform hover:scale-105 transition duration-300 ease-in-out">
    <h2 class="text-4xl font-bold">SPMB</h2>
    <p class="mt-2">Sistem Penerimaan Murid Baru</p>
<p class="text-sm text-indigo-600 cursor-pointer underline" onclick="document.getElementById('panduanModal').classList.remove('hidden')">
    Lihat Panduan Pendaftaran
</p>
  </div>

  <!-- Kartu Tengah -->
  <div class="bg-[#90caf9] p-6 rounded-lg shadow-md relative overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
    <h2 class="text-3xl font-bold">Persyaratan Pendaftaran</h2>
    <p class="mt-2 text-lg">Jalur Prestasi, KIP, Reguler</p>
    <!-- Tombol -->
<p class="text-sm text-indigo-600 cursor-pointer underline" onclick="document.getElementById('modal').classList.remove('hidden')">
    Lihat Persyaratan
</p>
  </div>
  

  <!-- Kartu Kanan -->
  <div class="bg-[#bbdefb] p-6 rounded-lg shadow-md text-center transform hover:scale-105 transition duration-300 ease-in-out">
    <p class="text-xl font-semibold text-gray-800">Hasil Seleksi</p>
<!-- Tombol Aksi -->
<a href="#" 
   onclick="event.preventDefault(); document.getElementById('popupSeleksi').classList.remove('hidden')" 
   class="bg-yellow-400 hover:bg-yellow-500 mt-4 px-4 py-2 rounded text-gray-900 font-semibold inline-block transition duration-300 ease-in-out transform hover:scale-105">
   Hasil Seleksi →
</a>

<!-- Popup Modal -->
<div id="popupSeleksi" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full relative animate-fade-in">
        <!-- Isi Pesan -->
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Informasi Seleksi</h2>
        <p class="text-sm text-gray-600 mb-4">
            Saat ini sekolah tidak dalam proses seleksi apapun.
        </p>

        <!-- Tombol Tutup -->
        <button onclick="document.getElementById('popupSeleksi').classList.add('hidden')" 
                class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
    </div>
</div>

<!-- Animasi (Opsional) -->
<style>
@keyframes fade-in {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
  animation: fade-in 0.25s ease-out;
}
</style>
  </div>
</section>

<!-- CARI HASIL SELEKSI -->
<section class="px-6 mt-6 animate-fade-in-up">
  <div class="bg-white rounded-lg shadow-md p-4 transition duration-300 ease-in-out hover:shadow-lg hover:scale-[1.01]">
    <h3 class="text-lg font-semibold mb-2">Cari Hasil Seleksi</h3>
    <div class="flex gap-2">
      <input type="text" placeholder="Masukan Nomor Pendaftaran..." class="w-full border px-4 py-2 rounded border-gray-300 focus:ring-2 focus:ring-green-400 transition">
      <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transform hover:scale-105 transition duration-300">Cari</button>
    </div>
  </div>
</section>

<style>
  @keyframes fadeSlideUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
  }

  @keyframes zoomIn {
    0% { opacity: 0; transform: scale(0.95); }
    100% { opacity: 1; transform: scale(1); }
  }

  .animate-fadeSlideUp {
    animation: fadeSlideUp 0.9s ease-out forwards;
  }

  .animate-zoomIn {
    animation: zoomIn 1.2s ease-out forwards;
  }
</style>

{{-- PANDUAN --}}
<!-- Modal / Popup -->
<div id="panduanModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full relative animate-fade-in">
        <!-- Header -->
        <h2 class="text-lg font-semibold text-indigo-700 mb-4">Panduan Pendaftaran</h2>

        <!-- Isi panduan -->
        <ol class="list-decimal pl-5 text-sm text-gray-700 space-y-2">
            <li>
            Klik tombol 
            <a href="/register" class="text-indigo-600 underline hover:text-indigo-800 font-semibold">
              Daftar Sekarang
            </a> 
            atau yang ada pada halaman utama.
          </li>

            <li>buat akun dengan email aktif anda.</li>
            <li>masuk/login dengan akun yang telah anda buat.</li>
            <li>pilih pendaftaran siswa baru yang ada pada menu sebelah kiri</li>
            <li>lengkapi data anda sesuai persyaratan dan jalur pendaftarannya</li>
            <li>pastikan data anda sudah sesuai</li>
            <li>klik daftar</li>
            <li>selesai, anda sudah mendaftarkan diri sebagai siswa/i SMK Hijau Muda</li>
            <li>pengumuman akan diinformasikan pada tanggal 5 Juli 2025 yang dikirimkan ke email aktif anda</li>
      
        </ol>

        <!-- Tombol Tutup -->
        <button onclick="document.getElementById('panduanModal').classList.add('hidden')" 
                class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
    </div>
</div>

{{-- persyaratan --}}

<!-- Modal / Popup -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative animate-fade-in 
              max-h-[90vh] overflow-y-auto"> 
      <h2 class="text-lg font-semibold text-indigo-700 mb-4">Persyaratan Pendaftaran Jalur Reguler</h2>
<ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
  <li>Fotokopi Ijazah atau Surat Keterangan Lulus dari sekolah asal.</li>
  <li>Fotokopi Kartu Keluarga (KK).</li>
  <li>Fotokopi Akta Kelahiran atau KTP.</li>
  <li>Pas foto berwarna ukuran 3x4 sebanyak 2 lembar.</li>
  <li>Mengisi formulir pendaftaran secara online atau langsung di sekolah.</li>
  <li>Mengikuti tes seleksi masuk (jika disyaratkan oleh sekolah).</li>
  <li>Melampirkan surat keterangan sehat dari puskesmas/klinik.</li>
</ul>
<br>
      <h2 class="text-lg font-semibold text-indigo-700 mb-4">Persyaratan Pendaftaran Jalur Prestasi</h2>
        <ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
            <li>Fotokopi Ijazah terakhir</li>
            <li>Pas foto ukuran 3x4 (2 lembar)</li>
            <li>Fotokopi KTP / Kartu Pelajar</li>
            <li>Mengisi formulir pendaftaran</li>
            <li>Melampirkan Sertifikat Kejuaraan Minimal Juara 3 Tingkat Kecamatan</li>
            <p>semua file di upload ke dalam formulir dalam format File Gambar (JPG, JPEG) atau file PDF</p>
        </ul>
        <br>
      <h2 class="text-lg font-semibold text-indigo-700 mb-4">Persyaratan Pendaftaran Jalur KIP</h2>
      <ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
        <li>Memiliki Kartu Indonesia Pintar (KIP) yang masih berlaku.</li>
        <li>Fotokopi KIP (1 lembar) dan menunjukkan aslinya saat verifikasi.</li>
        <li>Fotokopi Kartu Keluarga (KK).</li>
        <li>Fotokopi Akta Kelahiran atau KTP.</li>
        <li>Fotokopi rapor semester terakhir.</li>
        <li>Surat Keterangan Tidak Mampu dari Kelurahan/Desa (jika diminta).</li>
        <li>Pas foto terbaru ukuran 3x4 (2 lembar).</li>
        <li>Mengisi formulir pendaftaran online dengan data lengkap dan benar.</li>
      </ul>
        <!-- Tombol Tutup -->
        <!-- Tombol Tutup Bawah -->
    <div class="mt-6 text-left">
      <button onclick="document.getElementById('modal').classList.add('hidden')" 
              class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-200">
        Tutup
      </button>
    </div>
        <button onclick="document.getElementById('modal').classList.add('hidden')" 
                class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl font-bold">&times;</button>
    </div>
</div>

{{-- section kedua --}}
<div class="bg-white">
  <div class="mx-auto max-w-7xl py-10 sm:px-6 sm:py-10 lg:px-8">
    <div class="relative isolate overflow-hidden bg-gray-900 px-6 pt-16 shadow-2xl sm:rounded-3xl sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0 animate-zoomIn">
      <svg viewBox="0 0 1024 1024" class="absolute top-1/2 left-1/2 -z-10 size-256 -translate-y-1/2 mask-[radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0" aria-hidden="true">
        <circle cx="512" cy="512" r="512" fill="url(#759c1415-0410-454c-8f7c-9a820de03641)" fill-opacity="0.7" />
        <defs>
          <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
            <stop stop-color="#7775D6" />
            <stop offset="1" stop-color="#E935C1" />
          </radialGradient>
        </defs>
      </svg>
      <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left animate-fadeSlideUp">
        <h2 class="text-3xl font-semibold tracking-tight text-balance text-white sm:text-4xl">Tingkatkan Potensi Anak Anda Bersama Sekolah Kami</h2>
        <p class="mt-6 text-lg/8 text-pretty text-gray-300">"Mendidik generasi berkarakter kuat dan terampil di bidang teknologi, siap bersaing di dunia kerja dan industri global."</p>
        <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
        <a href="{{ route('register') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-transform duration-300 hover:scale-105">Daftar Sekarang</a>
          <a href="{{ url('/#jurusan') }}" class="text-sm/6 font-semibold text-white hover:underline">pelajari lebih lanjut <span aria-hidden="true">→</span></a>
        </div>
      </div>
      <div class="relative mt-16 h-80 lg:mt-8 animate-fadeSlideUp">
        <img class="absolute top-0 left-0 w-228 max-w-none rounded-md bg-white/5 ring-1 ring-white/10 shadow-lg hover:scale-105 transition-transform duration-500" src="images/landing.JPG" alt="App screenshot" width="1824" height="1080" />
      </div>
    </div>
  </div>
</div>




   <section class="bg-[#f9fafb] py-12 px-4 lg:px-20" x-data="{ tahap: 1 }">
  <h2 class="text-center text-2xl font-bold text-[#24555e] mb-8">Jadwal SPMB</h2>

  <!-- PILIH TAHAP -->
  <div class="flex justify-center mb-6 space-x-4">
    <button @click="tahap = 1"
      :class="tahap === 1 ? 'text-blue-500 border-blue-300' : 'text-gray-400 border-gray-300'"
      class="bg-white border rounded-lg px-6 py-2 font-semibold text-sm shadow transition duration-300">
      SPMB Tahap 1 <br>
      <span class="text-xs font-normal">Proses pendaftaran Reguler</span>
    </button>
    <button @click="tahap = 2"
      :class="tahap === 2 ? 'text-blue-500 border-blue-300' : 'text-gray-400 border-gray-300'"
      class="bg-white border rounded-lg px-6 py-2 font-semibold text-sm shadow transition duration-300">
      SPMB Tahap 2 <br>
      <span class="text-xs font-normal">Proses pendaftaran Prestasi</span>
    </button>
  </div>

  <!-- Tahap 1 -->
  <div x-show="tahap === 1" x-transition>
    @include('components.jadwal-tahap-1') 
    {{-- Buat file blade terpisah, atau isi langsung di sini --}}
  </div>

  <!-- Tahap 2 -->
  <div x-show="tahap === 2" x-transition>
    @include('components.jadwal-tahap-2')
    {{-- Isi dengan jadwal dan kuota Tahap 2 --}}
  </div>
</section>

{{-- jurusan --}}
<section class="bg-white py-16 px-4 sm:px-6 lg:px-8" id='jurusan'>
  <div class="max-w-7xl mx-auto text-center">
    <h2 class="text-3xl font-bold text-gray-900">Jurusan</h2>
    <p class="mt-2 text-lg text-gray-600">"Pilih jurusan sesuai minat kamu, dan kembangkan potensi terbaikmu bersama kami".</p>
  </div>

  <div class="mt-12 grid gap-6 lg:grid-cols-3 md:grid-cols-2">
    <!-- Card 1 -->
    <div class="relative overflow-hidden rounded-2xl shadow-md group">
      <img class="w-full h-60 object-cover group-hover:scale-105 transition duration-500" src="{{ asset('images/tkr.jpg') }}" alt="Blog 1">
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent p-4 flex flex-col justify-end">
        <h3 class="text-lg font-bold text-white">Teknik Kendaraan Ringan</h3>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="relative overflow-hidden rounded-2xl shadow-md group">
      <img class="w-full h-60 object-cover group-hover:scale-105 transition duration-500" src="{{ asset('images/tkj.jpeg') }}" alt="Blog 2">
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent p-4 flex flex-col justify-end">
        <h3 class="text-lg font-bold text-white">Teknik Komputer Jaringan Telekomunikasi</h3>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="relative overflow-hidden rounded-2xl shadow-md group">
      <img class="w-full h-60 object-cover group-hover:scale-105 transition duration-500" src="{{ asset('images/mp.webp') }}" alt="Blog 3">
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent p-4 flex flex-col justify-end">
        <h3 class="text-lg font-bold text-white">Manajemen Perkantoran</h3>
      </div>
    </div>
  </div>
</section>
{{-- 
<section class="bg-white py-16 px-6 lg:px-20">
  <div class="max-w-7xl mx-auto text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Warga Sekolah</h2>
    <p class="text-gray-600 mb-12">
      Kami adalah komunitas pendidikan yang terdiri dari para pendidik, staf, dan siswa yang bersinergi untuk menciptakan lingkungan belajar yang positif dan inspiratif. Bersama-sama, kami berkomitmen untuk membangun karakter, pengetahuan, dan semangat kolaborasi demi masa depan yang lebih baik.
    </p>

    <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3">
      @for($i = 1; $i <= 6; $i++)
      <div class="text-center">
        <img class="mx-auto w-40 h-40 rounded-xl object-cover" src="images/SMP.jpg" alt="Guru {{ $i }}">
        <h3 class="mt-4 text-lg font-semibold text-gray-900">Guru {{ $i }}</h3>
        <p class="text-sm text-gray-500">Mata Pelajaran {{ $i }}</p>
        <div class="mt-2 flex justify-center space-x-4">
          <a href="#" class="text-gray-400 hover:text-gray-600"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="text-gray-400 hover:text-gray-600"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
      @endfor
    </div>

    <!-- Static Pagination -->
    <div class="mt-10 flex justify-center space-x-2">
      <a href="#" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">1</a>
      <a href="#" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">2</a>
      <a href="#" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">3</a>
      <span class="px-3 py-1 text-gray-400">...</span>
      <a href="#" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Next →</a>
    </div>
  </div>
</section>
 --}}


    <!-- FOOTER -->
    <footer class="bg-teal-800 text-white border-t border-gray-200 mt-10">
      <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row justify-between">
          <div class="mb-10 md:mb-0 md:w-1/4">
            <img class="h-auto w-28 mb-4" src="images/hm.png" alt="Logo">
            <p class="text-sm">SMK Hijau Muda berkomitmen mencetak generasi unggul berbasis teknologi dan karakter.</p>
            <div class="flex space-x-4 mt-4">
              <a href="#" class="hover:underline">Facebook</a>
              <a href="#" class="hover:underline">Instagram</a>
              <a href="#" class="hover:underline">Twitter</a>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:grid-cols-4 md:w-3/4">
            <div>
              <h3 class="text-sm font-semibold text-yellow-500 mb-4">Beranda</h3>
              <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Jurusan</a></li>
                <li><a href="#" class="hover:underline">Warga Sekolah</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-yellow-500 mb-4">SPMB</h3>
              <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Jadwal SPMB</a></li>
                <li><a href="#" class="hover:underline">#</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-yellow-500 mb-4">#</h3>
              <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">About</a></li>
                <li><a href="#" class="hover:underline">Blog</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-yellow-500 mb-4">Pendaftaran</h3>
              <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Terms of service</a></li>
<!-- Trigger Button -->
<p class="text-sm text-white cursor-pointer hover:text-gray-300 transition"
   onclick="document.getElementById('privacyModal').classList.remove('hidden')">
  Kebijakan Privasi
</p>

<!-- Modal / Popup -->
<div id="privacyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl w-full relative max-h-[90vh] overflow-y-auto animate-fade-in">
    
    <!-- Judul -->
    <h2 class="text-xl font-semibold text-indigo-700 mb-4">Kebijakan Privasi – e-School untuk SMK HIJAU MUDA</h2>
    <p class="text-sm text-gray-500 mb-2">Terakhir diperbarui: Juli 2025</p>

    <!-- Isi Kebijakan -->
    <div class="space-y-6 text-sm text-gray-700">
      <div>
        <h3 class="font-semibold text-gray-900">1. Informasi yang Kami Kumpulkan</h3>
        <ul class="list-disc pl-5">
          <li>Data identitas (nama, NISN/NIP, email, dll)</li>
          <li>Data akademik (nilai, kehadiran, tugas, dsb)</li>
          <li>Data teknis (IP address, perangkat, waktu login)</li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">2. Tujuan Pengumpulan Data</h3>
        <ul class="list-disc pl-5">
          <li>Penyediaan layanan belajar dan manajemen sekolah</li>
          <li>Notifikasi kegiatan dan komunikasi sekolah</li>
          <li>Analisis internal sistem</li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">3. Pengungkapan kepada Pihak Ketiga</h3>
        <p>Kami tidak membagikan data Anda kecuali untuk keperluan hukum atau teknis dengan perjanjian kerahasiaan.</p>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">4. Keamanan Data</h3>
        <p>Data disimpan secara terenkripsi di server aman dan hanya bisa diakses oleh pihak berwenang.</p>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">5. Hak Pengguna</h3>
        <ul class="list-disc pl-5">
          <li>Melihat, mengubah, atau menghapus data pribadi</li>
          <li>Meminta penghapusan akun (dengan ketentuan sekolah)</li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">6. Cookie dan Pelacakan</h3>
        <p>Kami menggunakan cookie untuk menyimpan preferensi login dan meningkatkan pengalaman pengguna.</p>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">7. Perubahan Kebijakan</h3>
        <p>Kami dapat memperbarui kebijakan ini. Semua perubahan akan diumumkan melalui sistem.</p>
      </div>

      <div>
        <h3 class="font-semibold text-gray-900">8. Kontak</h3>
        <p>
          📧 admin@smkhijaumuda.sch.id<br>
          ☎️ (0267) 123456<br>
          📍 Kp. Walahir Desa Karangraharja Kecamatan Cikarang Utara, 17350
        </p>
      </div>
    </div>

    <!-- Tombol Tutup Bawah -->
    <div class="mt-6 text-right">
      <button onclick="document.getElementById('privacyModal').classList.add('hidden')" 
              class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-200">
        Tutup
      </button>
    </div>

    <!-- Tombol Tutup Atas -->
    <button onclick="document.getElementById('privacyModal').classList.add('hidden')" 
            class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl font-bold">&times;</button>
  </div>
</div>

              </ul>
            </div>
          </div>
        </div>
        <div class="mt-12 border-t pt-6 text-center text-sm">© 2025 SMK Hijau Muda, Inc. All rights reserved.
          <p class="mt-2 text-xs text-gray-400">
            Developed by <span class="text-white font-semibold">Muhammad Andika Anjas Syaputra, S.Kom.</span>
        </p>
        </div>
      </div>
    </footer>
  </body>
</html>