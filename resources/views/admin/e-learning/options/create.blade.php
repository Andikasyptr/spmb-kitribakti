@extends('layouts.app')
@include('components.sidebar-admin')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Tambah Pilihan untuk Soal: {{ $question->question_text }}</h1>

    <form action="{{ route('admin.options.store', $question->id) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label>Pilihan Jawaban</label>
            <input type="text" name="option_text" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Jawaban Benar?</label>
            <input type="checkbox" name="is_correct" value="1">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
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
