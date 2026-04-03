<div class="grid lg:grid-cols-3 gap-6">
  <!-- Kolom Kiri -->
  <div class="space-y-4">
    <div class="bg-green-400 text-white p-4 rounded-md">
      <h3 class="font-bold mb-2">Pendaftaran Tahap 2</h3>
      <div class="space-y-1 text-sm">
        {{-- <div class="flex justify-between"><span>MPLS dan LDKS</span><span>Rp. 150.000</span></div>
        <div class="flex justify-between"><span>Seragam</span><span>Rp. 500.000</span></div> --}}
        <div class="flex justify-between"><span>Biaya (Free Seragam Olahraga)</span><span>Rp. 500.000</span></div>
      </div>
    </div>

   <div class="bg-green-400 text-white p-4 rounded-md">
      <h3 class="font-bold mb-2">Tata Cara Pendaftaran</h3>
      <div class="space-y-1 text-sm">
        <div class="flex justify-between"><span>Mengisi formulir pendaftaran online pada sistem aplikasi</span></div>
        <div class="flex justify-between"><span>upload foto atau scan PDF Surat Keterangan lulus</span></div>
        <div class="flex justify-between"><span>upload foto atau scan PDF Ijazah sekolah asal (jika ada) *tidak wajib</span></div>
        <div class="flex justify-between"><span>upload foto atau scan PDF Kartu Keluarga, AKTA dan NISN</span></div>

      </div>
    </div>
  </div>

  <!-- Jadwal -->
  <div class="lg:col-span-2">
    <div class="bg-white p-6 rounded-md shadow border">
      <h3 class="text-lg font-semibold mb-4">Jadwal SPMB Tahap 2</h3>
      <ol class="relative border-l border-green-300 space-y-6">
        @php
    // Konfigurasi Tanggal Tahap 2
    $start = \Carbon\Carbon::create(2026, 3, 15);
    $end = \Carbon\Carbon::create(2026, 6, 1);
    $now = now();

    // Penentuan Status & Warna
    if ($now->lt($start)) {
        $statusLabel = 'Mendatang';
        $themeColor = 'bg-gray-300'; // Abu-abu untuk yang belum mulai
        $textColor = 'text-gray-500';
    } elseif ($now->between($start, $end)) {
        $statusLabel = 'Sedang Berlangsung';
        $themeColor = 'bg-green-500'; // Hijau menyala untuk yang aktif
        $textColor = 'text-green-600';
    } else {
        $statusLabel = 'Selesai';
        $themeColor = 'bg-gray-400'; // Abu-abu tua untuk yang lewat
        $textColor = 'text-gray-400';
    }
@endphp

<li class="relative ml-6 pb-10 border-l-2 border-gray-200 last:border-0 last:pb-0">
    <div class="absolute -left-[9px] top-1 w-4 h-4 {{ $themeColor }} rounded-full border-2 border-white shadow-sm"></div>

    <div class="ml-4">
        <div class="flex flex-wrap items-center gap-2 mb-1">
            <h3 class="text-base font-bold text-gray-800">Pendaftaran Online Tahap 2</h3>
            
            <span class="{{ $themeColor }} {{ $statusLabel == 'Sedang Berlangsung' ? 'animate-pulse' : '' }} text-white text-[10px] uppercase tracking-wider font-extrabold px-2 py-0.5 rounded">
                {{ $statusLabel }}
            </span>
        </div>

        <div class="flex items-center text-sm {{ $textColor }} font-medium">
            <svg class="w-4 h-4 mr-1.5 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>15 Maret 2026 - 1 Juni 2026</span>
        </div>

        <p class="mt-2 text-xs text-gray-500 italic">
            *Pastikan seluruh dokumen persyaratan sudah diunggah sebelum batas waktu berakhir.
        </p>
    </div>
</li>
        <li class="ml-4">
          <div class="absolute -left-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
          <p class="font-semibold">Registrasi Ulang Peserta MPLS</p>
          <p class="text-sm text-gray-600">📅 Juli 2026</p>
          <span class="bg-gray-400 text-white text-xs font-semibold px-2 py-1 rounded">belum dimulai</span>
        </li>
      </ol>
    </div>
  </div>
</div>
