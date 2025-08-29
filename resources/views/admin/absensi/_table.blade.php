<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full table-auto border-collapse border text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Jam Masuk</th>
                <th class="border px-4 py-2">Jam Pulang</th>
                <th class="border px-4 py-2">Status Masuk</th>
                <th class="border px-4 py-2">Status Pulang</th>
                <th class="border px-4 py-2">Lokasi Masuk</th>
                <th class="border px-4 py-2">Lokasi Pulang</th>
                <th class="border px-4 py-2">Foto Masuk</th>
                <th class="border px-4 py-2">Foto Pulang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $index => $absen)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $absensis->firstItem() + $index }}</td>
                    <td class="border px-4 py-2">{{ $absen->user->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $absen->tanggal }}</td>
                    <td class="border px-4 py-2">{{ $absen->jam_masuk ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $absen->jam_pulang ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $absen->status_masuk ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $absen->status_pulang ?? '-' }}</td>

                    {{-- Lokasi Masuk --}}
                    <td class="border px-4 py-2">
                        @if($absen->lokasi_masuk)
                            <a href="https://www.google.com/maps?q={{ urlencode($absen->lokasi_masuk) }}"
                               target="_blank" class="text-blue-600 underline">
                                Lihat Lokasi
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    {{-- Lokasi Pulang --}}
                    <td class="border px-4 py-2">
                        @if($absen->lokasi_pulang)
                            <a href="https://www.google.com/maps?q={{ urlencode($absen->lokasi_pulang) }}"
                               target="_blank" class="text-blue-600 underline">
                                Lihat Lokasi
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    {{-- Foto Masuk --}}
                    <td class="border px-4 py-2">
                         @if ($absen->foto_masuk)
                            <a href="{{ asset($absen->foto_masuk) }}" target="_blank" class="text-blue-600 underline text-sm">
                                Lihat Foto
                            </a>
                        @else
                            <span class="text-sm text-gray-500">-</span>
                        @endif
                    </td>

                    {{-- Foto Pulang --}}
                    <td class="border px-4 py-2">
                        @if ($absen->foto_pulang)
                            <a href="{{ asset($absen->foto_pulang) }}" target="_blank" class="text-blue-600 underline text-sm">
                                Lihat Foto
                            </a>
                        @else
                            <span class="text-sm text-gray-500">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="border px-4 py-2 text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 px-4">
        {{ $absensis->links() }}
    </div>
</div>
