{{-- resources/views/admin/data-ujian-siswa/show.blade.php --}}
@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Nilai Ujian: '.$exam->title)

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800">
            📊 Nilai Siswa - {{ $exam->title }}
        </h1>

        {{-- ✅ Tombol Export Excel --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <a href="{{ route('data-ujian-siswa.export', $exam->id) }}{{ http_build_query(request()->all()) ? '?'.http_build_query(request()->all()) : '' }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg w-full sm:w-auto text-center transition">
                ⬇️ Export Excel
            </a>
        </div>

        {{-- ✅ Filter Form --}}
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="kelas_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" @selected(request('kelas_id') == $kelas->id)>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <select name="jurusan" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($jurusanList as $j)
                        <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Kelas</label>
                <select name="kode_kelas" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua --</option>
                    <option value="1" @selected(request('kode_kelas') == '1')>1</option>
                    <option value="2" @selected(request('kode_kelas') == '2')>2</option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-2 sm:col-span-2 mt-2 sm:mt-0">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition w-full sm:w-auto">
                    Filter
                </button>
                <a href="{{ route('data-ujian-siswa.show', $exam->id) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition w-full sm:w-auto text-center">
                    Reset
                </a>
            </div>
        </form>

        {{-- ✅ Tabel Nilai --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs sm:text-sm">
                    <tr>
                        <th class="px-3 py-2"><input type="checkbox" id="selectAll"></th>
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Nama Siswa</th>
                        <th class="px-3 py-2">Kelas</th>
                        <th class="px-3 py-2">Kode Kelas</th>
                        <th class="px-3 py-2">Jurusan</th>
                        <th class="px-3 py-2">Nilai</th>
                        <th class="px-3 py-2 whitespace-nowrap">Tanggal</th>
                        <th class="px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $no = 1; @endphp
                    @forelse($siswas as $siswa)
                        @php
                            $userId = $siswa->user->id ?? null;
                            $res = $userId ? ($results[$userId] ?? null) : null;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 py-2">
                                @if($userId)
                                    <input type="checkbox" name="student_ids[]" value="{{ $userId }}">
                                @endif
                            </td>
                            <td class="px-3 py-2">{{ $no++ }}</td>
                            <td class="px-3 py-2">{{ $siswa->user->name ?? 'Belum memiliki akun' }}</td>
                            <td class="px-3 py-2">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $siswa->kode_kelas ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $siswa->jurusan ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $res->score ?? 0 }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ $res ? $res->created_at->format('d M Y') : '-' }}</td>
                            <td class="px-3 py-2 text-center">
                                @if($userId)
                                    <a href="{{ route('admin.data-ujian-siswa.view-answers', [
                                        'exam' => $exam->id,
                                        'student' => $siswa->user->id
                                    ]) }}" class="text-blue-600 hover:underline">
                                        🔍 Lihat Jawaban
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-3 text-center text-gray-500">
                                Belum ada siswa terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Dropdown Hapus --}}
        <div class="relative inline-block text-left mt-6" x-data="{ open: false }">
            <button @click="open = !open" 
                    type="button" 
                    class="inline-flex justify-center items-center w-full sm:w-auto rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-red-600 text-white hover:bg-red-700 transition">
                Hapus Jawaban Siswa
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition 
                 class="absolute right-0 mt-2 w-56 bg-white border rounded-md shadow-lg z-50">
                <div class="py-1">
                    <button id="delete-multiple-btn" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Hapus yang Dipilih
                    </button>

                    <form action="{{ route('admin.ujian.delete-all', $exam->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus semua jawaban siswa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Hapus Semua
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();

    // ✅ Select All checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('click', function() {
            const checked = this.checked;
            document.querySelectorAll('input[name="student_ids[]"]').forEach(cb => cb.checked = checked);
        });
    }

    // ✅ Delete multiple siswa
    const deleteMultipleBtn = document.getElementById('delete-multiple-btn');
    if (deleteMultipleBtn) {
        deleteMultipleBtn.addEventListener('click', function() {
            const selected = Array.from(document.querySelectorAll('input[name="student_ids[]"]:checked'))
                .map(cb => cb.value);

            if (selected.length === 0) {
                Swal.fire('Oops!', 'Pilih minimal satu siswa untuk dihapus!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Hapus jawaban siswa terpilih?',
                text: `Jumlah siswa: ${selected.length}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('admin.ujian.delete-multiple', $exam->id) }}";
                    form.innerHTML = `@csrf @method('DELETE')`;
                    selected.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'student_ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    }
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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