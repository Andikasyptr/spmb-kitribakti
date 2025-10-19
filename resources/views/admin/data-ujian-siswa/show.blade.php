{{-- resources/views/admin/data-ujian-siswa/show.blade.php --}}

@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Nilai Ujian: '.$exam->title)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">📊 Nilai Siswa - {{ $exam->title }}</h1>

        {{-- Export Excel --}}
        <a href="{{ route('data-ujian-siswa.export', $exam->id) }}{{ http_build_query(request()->all()) ? '?'.http_build_query(request()->all()) : '' }}" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            ⬇️ Export Excel
        </a>

        {{-- Filter Form --}}
        <form method="GET" class="mt-4 mb-4 flex flex-col sm:flex-row sm:flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" class="w-full border px-2 py-1 rounded">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" @selected(request('kelas_id') == $kelas->id)>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                <select name="jurusan" class="w-full border px-2 py-1 rounded">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($jurusanList as $j)
                        <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                <select name="kode_kelas" class="w-full border px-2 py-1 rounded">
                    <option value="">-- Semua --</option>
                    <option value="1" @selected(request('kode_kelas') == '1')>1</option>
                    <option value="2" @selected(request('kode_kelas') == '2')>2</option>
                </select>
            </div>

            <div class="flex gap-2 mt-2 sm:mt-0">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full sm:w-auto">
                    Filter
                </button>
                <a href="{{ route('data-ujian-siswa.show', $exam->id) }}" 
                   class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100 w-full sm:w-auto text-center">
                    Reset
                </a>
            </div>
        </form>

        {{-- Table Nilai --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kode Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jurusan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $no = 1; @endphp
                    @forelse($siswas as $siswa)
                        @php
                            $userId = $siswa->user->id ?? null;
                            $res = $userId ? ($results[$userId] ?? null) : null;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                @if($userId)
                                    <input type="checkbox" name="student_ids[]" value="{{ $userId }}">
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $no++ }}</td>
                            <td class="px-4 py-2">{{ $siswa->user->name ?? 'Belum memiliki akun' }}</td>
                            <td class="px-4 py-2">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $siswa->kode_kelas ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $siswa->jurusan ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $res->score ?? 0 }}</td>
                            <td class="px-4 py-2">{{ $res ? $res->created_at->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($res)
                                <button data-student="{{ $userId }}" data-exam="{{ $exam->id }}" class="delete-answer-btn text-red-600 hover:text-red-800 font-semibold flex items-center gap-1 transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            
                           <td class="px-4 py-2">
                                 <a href="{{ route('admin.data-ujian-siswa.view-answers', [
                                        'exam' => $exam->id,
                                        'student' => $siswa->user->id  
                                    ]) }}" class="text-blue-600 hover:underline">
                                        🔍 Lihat Jawaban
                                    </a>
                            </td>

                        
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-2 text-center text-gray-500">Belum ada siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Hapus Dropdown / Modal --}}
        <div class="relative inline-block text-left mt-4 mb-4" x-data="{ open: false }">
            <button @click="open = !open" 
                    type="button" 
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-red-600 text-white hover:bg-red-700">
                Hapus Jawaban Siswa
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition 
                 class="absolute right-0 mt-2 w-56 bg-white border rounded-md shadow-lg z-50">
                <div class="py-1">
                    {{-- Hapus Multiple --}}
                    <button id="delete-multiple-btn" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Hapus yang dipilih</button>

                    {{-- Hapus All --}}
                    <form action="{{ route('admin.ujian.delete-all', $exam->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua jawaban siswa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Hapus Semua</button>
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

    // Select All checkbox
    const selectAll = document.getElementById('selectAll');
    if(selectAll){
        selectAll.addEventListener('click', function(){
            const checked = this.checked;
            document.querySelectorAll('input[name="student_ids[]"]').forEach(cb => cb.checked = checked);
        });
    }

    // Delete single siswa
    document.querySelectorAll('.delete-answer-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const studentId = this.dataset.student;
            const examId = this.dataset.exam;

            Swal.fire({
                title: 'Hapus jawaban siswa ini?',
                text: 'Semua jawaban dan nilai siswa untuk ujian ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/data-ujian-siswa/${examId}/${studentId}/delete-answer`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                        else Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                    })
                    .catch(() => Swal.fire('Error!', 'Tidak dapat menghapus jawaban.', 'error'));
                }
            });
        });
    });

    // Delete multiple siswa
    const deleteMultipleBtn = document.getElementById('delete-multiple-btn');
    deleteMultipleBtn.addEventListener('click', function() {
        const selected = Array.from(document.querySelectorAll('input[name="student_ids[]"]:checked'))
                              .map(cb => cb.value);

        if(selected.length === 0){
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
            if(result.isConfirmed){
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.ujian.delete-multiple', $exam->id) }}";

                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;

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
});
</script>
@endpush
