@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Jawaban Siswa - ' . $exam->nama_ujian)

@section('content')
<div class="space-y-6">

    @foreach($exam->questions as $index => $question)
        @php
            $studentAnswer = $studentAnswers[$question->id] ?? null;
            $selectedOptionId = $studentAnswer?->option_id ?? null;
            $isCorrect = $studentAnswer?->is_correct ?? 0;

            // Card merah hanya jika siswa tidak menjawab
            $cardBg = $selectedOptionId ? 'bg-white' : 'bg-red-50';
        @endphp

        <div class="p-4 border rounded-lg shadow-md {{ $cardBg }}">
            <p class="font-semibold text-gray-800 mb-3">
                {{ $index + 1 }}. {{ $question->question_text }} 
                <span class="text-sm text-gray-500">({{ $question->point ?? 0 }} poin)</span>
            </p>

            <div class="space-y-2">
                @foreach($question->options as $option)
                    @php
                        $optionSelected = $selectedOptionId == $option->id;
                        // Semua opsi tetap netral
                        $bgClass = 'bg-gray-50 border-gray-200';
                        $textColor = 'text-gray-800';
                        $label = null;

                        if ($optionSelected) {
                            if ($isCorrect) {
                                $bgClass = 'bg-green-50 border-green-300';
                                $textColor = 'text-green-800 font-semibold';
                                $label = '✅ Jawaban Benar';
                            } else {
                                $bgClass = 'bg-red-50 border-red-300';
                                $textColor = 'text-red-800 font-semibold';
                                $label = '❌ Jawaban Salah';
                            }
                        }
                    @endphp

                    <div class="flex items-center gap-2 p-3 border rounded {{ $bgClass }}">
                        <input type="radio" disabled 
                               class="cursor-not-allowed" 
                               name="question_{{ $question->id }}" 
                               value="{{ $option->id }}" 
                               @if($optionSelected) checked @endif>

                        <span class="flex-1 {{ $textColor }}">{{ $option->option_label }}. {{ $option->option_text }}</span>

                        @if($label)
                            <span class="flex items-center gap-1">{{ $label }}</span>
                        @endif
                    </div>
                @endforeach

                @if(!$selectedOptionId)
                    <p class="text-red-600 text-sm mt-1">Jawaban Tidak Dijawab</p>
                @endif
            </div>
        </div>
    @endforeach

</div>
@endsection
