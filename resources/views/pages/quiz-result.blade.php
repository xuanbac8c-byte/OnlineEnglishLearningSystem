{{-- ================================================================
   FILE: resources/views/pages/student/quiz-attempt.blade.php
================================================================ --}}
@extends('layouts.dashboard')
@section('title', 'Làm bài quiz')
@section('page-title', $quiz->title)
@section('sidebar-label', 'HỌC VIÊN')
@section('sidebar-nav')
    <a href="{{ route('student.dashboard') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-house"></i><span>Tổng quan</span></a>
    <a href="{{ route('student.my-courses') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-book-open"></i><span>Khóa học của tôi</span></a>
@endsection
@section('content')
<div style="max-width: 760px; margin: 0 auto;">

    {{-- Timer --}}
    @if($timeLimit)
    <div class="dash-card" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <span style="font-size: 14px; color: #475569;">Thời gian còn lại</span>
        <span id="timer" style="font-size: 22px; font-weight: 800; color: #ef4444; font-family: monospace;">
            {{ gmdate('i:s', $timeLimit) }}
        </span>
    </div>
    @endif

    <form action="{{ route('student.quiz.submit', $attempt->quiz_attempt_id) }}" method="POST" id="quiz-form">
        @csrf

        @foreach($quiz->quizQuestions as $qIdx => $question)
        <div class="dash-card" style="margin-bottom: 16px;">
            <div style="display: flex; gap: 14px; align-items: flex-start; margin-bottom: 16px;">
                <div style="width: 32px; height: 32px; background: rgb(40,40,254); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0;">
                    {{ $qIdx + 1 }}
                </div>
                <div>
                    <p style="font-size: 15px; font-weight: 600; color: #0f172a; line-height: 1.6;">{{ $question->question }}</p>
                    <span style="font-size: 12px; color: #94a3b8;">{{ $question->points }} điểm</span>
                </div>
            </div>

            <input type="hidden" name="answers[{{ $qIdx }}][question_id]" value="{{ $question->quiz_question_id }}">

            @if(in_array($question->question_type, ['single_choice', 'true_false']))
                <div style="display: flex; flex-direction: column; gap: 10px; padding-left: 46px;">
                    @foreach($question->quizOptions->sortBy('sort_order') as $option)
                    <label style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition: border-color 0.15s;"
                           onmouseover="this.style.borderColor='rgb(40,40,254)'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <input type="radio" name="answers[{{ $qIdx }}][selected_option_id]" value="{{ $option->quiz_option_id }}"
                               style="accent-color: rgb(40,40,254); width: 16px; height: 16px; flex-shrink: 0;">
                        <span style="font-size: 14px; color: #374151;">{{ $option->option_text }}</span>
                    </label>
                    @endforeach
                </div>
            @elseif($question->question_type === 'multiple_choice')
                <div style="display: flex; flex-direction: column; gap: 10px; padding-left: 46px;">
                    @foreach($question->quizOptions->sortBy('sort_order') as $option)
                    <label style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 10px; cursor: pointer;">
                        <input type="checkbox" name="answers[{{ $qIdx }}][selected_option_id][]" value="{{ $option->quiz_option_id }}"
                               style="accent-color: rgb(40,40,254); width: 16px; height: 16px; flex-shrink: 0;">
                        <span style="font-size: 14px; color: #374151;">{{ $option->option_text }}</span>
                    </label>
                    @endforeach
                </div>
            @else
                <div style="padding-left: 46px;">
                    <input type="text" name="answers[{{ $qIdx }}][answer_text]" placeholder="Nhập câu trả lời..."
                           style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; outline: none;"
                           onfocus="this.style.borderColor='rgb(40,40,254)'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            @endif
        </div>
        @endforeach

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px;">
            <button type="button" onclick="if(confirm('Bạn chắc chắn muốn nộp bài?')) document.getElementById(\'quiz-form\').submit();"
                    style="padding: 14px 32px; background: rgb(40,40,254); color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer;">
                Nộp bài <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>

@if($timeLimit)
<script>
let secs = {{ $timeLimit }};
const timerEl = document.getElementById('timer');
const interval = setInterval(() => {
    secs--;
    if (secs <= 0) { clearInterval(interval); document.getElementById('quiz-form').submit(); return; }
    const m = Math.floor(secs/60).toString().padStart(2,'0');
    const s = (secs%60).toString().padStart(2,'0');
    timerEl.textContent = m + ':' + s;
    if (secs <= 60) timerEl.style.color = '#ef4444';
}, 1000);
</script>
@endif
@endsection