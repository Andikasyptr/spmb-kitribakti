@extends('layouts.app')
@include('components.sidebar-admin')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Pilihan Jawaban: {{ $question->question_text }}</h1>
        <a href="{{ route('guru.options.create', $question->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Pilihan</a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Pilihan</th>
                <th class="p-2 border">Benar?</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($options as $option)
                <tr>
                    <td class="p-2 border">{{ $option->option_text }}</td>
                    <td class="p-2 border">{{ $option->is_correct ? '✅ Ya' : '❌ Tidak' }}</td>
                    <td class="p-2 border flex gap-2">
                        <a href="{{ route('guru.options.edit', [$question->id, $option->id]) }}" class="bg-green-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('guru.options.destroy', [$question->id, $option->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
