@extends('layouts.app')
@include('components.sidebar-guru')
@section('title', 'Jawaban Siswa: '.$student->user->name)

@section('content')
<div class="py-6 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Jawaban Siswa - {{ $student->user->name }} ({{ $exam->title }})
    </h1>

    @if($questions->isEmpty())
        <p class="text-gray-500">Belum ada soal yang dibuat untuk ujian ini.</p>
    @else
        <div class="space-y-6">
            @foreach($questions as $index => $question)
                @php
                    $studentAnswer = $studentAnswers[$question->id] ?? null;
                    $selectedOptionId = $studentAnswer->option_id ?? null;
                    $isCorrect = $studentAnswer->is_correct ?? 0; // 1 = benar, 0 = salah / tidak dijawab

                    // Background card
                    $cardBg = $selectedOptionId 
                        ? ($isCorrect ? 'bg-green-50' : 'bg-red-50') 
                        : 'bg-red-50'; // jika tidak dijawab, merah
                @endphp

                <div class="p-4 border rounded-lg shadow-sm {{ $cardBg }} transition duration-200">
                    <p class="font-semibold text-gray-800 mb-3">
                        <span class="font-bold mr-2">{{ $index + 1 }}.</span>
                        {{ $question->question_text }}
                        @if($question->point)
                            <span class="text-sm text-gray-500">({{ $question->point }} poin)</span>
                        @endif
                    </p>

                    <div class="space-y-2">
                        @foreach($question->options as $option)
                            @php
                                $isSelected = $selectedOptionId == $option->id;
                                $textColor = $isSelected ? ($isCorrect ? 'text-green-800 font-bold' : 'text-red-800 font-bold') : 'text-gray-800';
                            @endphp

                            <label class="flex items-center gap-2 p-2 border rounded cursor-not-allowed {{ $textColor }}">
                                <input type="radio" disabled 
                                       class="form-radio cursor-not-allowed" 
                                       name="question_{{ $question->id }}" 
                                       value="{{ $option->id }}"
                                       @if($isSelected) checked @endif>
                                <span>{{ $option->option_label }}. {{ $option->option_text }}</span>

                                @if($isSelected)
                                    <span class="ml-2 px-2 py-0.5 text-sm rounded {{ $isCorrect ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900' }}">
                                        {{ $isCorrect ? 'Jawaban Benar' : 'Jawaban Salah' }}
                                    </span>
                                @endif
                            </label>
                        @endforeach

                        @if(!$selectedOptionId)
                            <p class="text-red-600 text-sm mt-1">Jawaban Tidak Dijawab</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
