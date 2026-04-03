<div class="grid lg:grid-cols-3 gap-6">
  <!-- Kolom Kiri -->
  <div class="space-y-4">
    <div class="bg-green-400 text-white p-4 rounded-md">
      <h3 class="font-bold mb-2">Pendaftaran Tahap 1</h3>
      <div class="space-y-1 text-sm">
        <div class="flex justify-between"><span>Biaya (Free Seragam Olahraga)</span><span>Rp. 450.000</span></div>
        {{-- <div class="flex justify-between"><span>MPLS dan LDKS</span><span>Rp. 150.000</span></div>
        <div class="flex justify-between"><span>Seragam</span><span>Rp. 500.000</span></div>
        <div class="flex justify-between"><span>Ekstrakurikuler</span><span>Rp. 75.000</span></div> --}}
      </div>
    </div>

    <div class="bg-green-400 text-white p-4 rounded-md">
      <h3 class="font-bold mb-2">Tata Cara Pendaftaran</h3>
      <div class="space-y-1 text-sm">
        <div class="flex justify-between"><span>Mengisi formulir pendaftaran online pada sistem aplikasi</span></div>
        <div class="flex justify-between"><span>upload foto atau scan PDF Surat Keterangan lulus</span></div>
        <div class="flex justify-between"><span>upload foto atau scan PDF Ijazah sekolah asal (jika ada) *tidak wajib</span></div>
        <div class="flex justify-between"><span>upload foto atau scan PDF Kartu Keluarga, AKTA, dan NISN</span></div>
        
      </div>
    </div>
  </div>

  <!-- Jadwal -->
  <div class="lg:col-span-2">
    <div class="bg-white p-6 rounded-md shadow border">
      <h3 class="text-lg font-semibold mb-4">Jadwal SPMB Tahap 1</h3>
      <ol class="relative border-l border-green-300 space-y-6">
        @php
    $tanggalMulai = \Carbon\Carbon::parse('2025-12-01');
    $tanggalSelesai = \Carbon\Carbon::parse('2026-03-01');
    $hariIni = now();
@endphp

@php
    // Ganti dengan data dari database jika ada
    $startDate = \Carbon\Carbon::create(2025, 12, 1);
    $endDate = \Carbon\Carbon::create(2026, 3, 1);
    $now = now();

    // Logika Status
    if ($now->lt($startDate)) {
        $status = 'mendatang';
        $color = 'bg-yellow-500';
        $label = 'Akan Datang';
    } elseif ($now->between($startDate, $endDate)) {
        $status = 'aktif';
        $color = 'bg-blue-600';
        $label = 'Sedang Berlangsung';
    } else {
        $status = 'selesai';
        $color = 'bg-gray-400';
        $label = 'Selesai';
    }
@endphp

<li class="relative ml-6 pb-8 border-l-2 border-gray-200 last:border-0 last:pb-0">
    <div @class([
        'absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-white shadow-sm',
        $color
    ])></div>

    <div class="flex flex-col gap-1 ml-4">
        <div class="flex items-center gap-3">
            <h3 class="font-bold text-gray-800 leading-none">Pendaftaran Online Tahap 1</h3>
            <span @class([
                'text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded shadow-sm text-white',
                $color
            ])>
                {{ $label }}
            </span>
        </div>
        
        <div class="flex items-center text-sm text-gray-500 mt-1">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>1 Desember 2025 - 1 Maret 2026</span>
        </div>
    </div>
</li>
        <li class="ml-4">
          <div class="absolute -left-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
          <p class="font-semibold">Registrasi Ulang Peserta MPLS</p>
          <p class="text-sm text-gray-600">📅 Juli 2026</p>
          <span class="bg-gray-400 text-white text-xs font-semibold px-2 py-1 rounded">Belum dimulai</span>
        </li>
      </ol>
    </div>
  </div>
</div>
