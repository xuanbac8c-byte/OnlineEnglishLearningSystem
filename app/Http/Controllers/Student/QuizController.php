<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use IQuizAnswerService;
use IQuizAttemptService;
use IQuizOptionService;
use IQuizService;

class QuizController extends Controller
{
    public function __construct(
        protected IQuizService        $quizService,
        protected IQuizAttemptService $attemptService,
        protected IQuizAnswerService  $answerService,
        protected IQuizOptionService  $optionService,
    ) {}

    /**
     * Trang bắt đầu quiz (giới thiệu + lịch sử).
     */
    public function show(int $quizId)
    {
        $quiz     = $this->quizService->findById($quizId);
        $userId   = session('user_id');
        $canStart = $this->quizService->canAttempt($userId, $quizId);
        $history  = $this->attemptService->getByQuiz($quizId)
                        ->where('user_id', $userId);
        $bestScore = $this->attemptService->getBestScore($userId, $quizId);

        return view('pages.student.quiz', compact('quiz', 'canStart', 'history', 'bestScore'));
    }

    /**
     * Bắt đầu làm bài — tạo attempt mới.
     */
    public function start(int $quizId)
    {
        $userId = session('user_id');

        if (!$this->quizService->canAttempt($userId, $quizId)) {
            return back()->withErrors('Bạn đã dùng hết số lần làm bài cho phép.');
        }

        $attempt = $this->attemptService->start($userId, $quizId);

        return redirect()->route('student.quiz.attempt', $attempt->quiz_attempt_id);
    }

    /**
     * Trang làm bài (hiển thị câu hỏi + options).
     */
    public function attempt(int $attemptId)
    {
        $attempt = $this->attemptService->findById($attemptId);

        // Chặn xem bài của người khác
        if ($attempt->user_id !== session('user_id')) {
            abort(403);
        }

        // Đã nộp rồi → redirect kết quả
        if ($attempt->submitted_at) {
            return redirect()->route('student.quiz.result', $attemptId);
        }

        $quiz      = $attempt->quiz->load('quizQuestions.quizOptions');
        $timeLimit = $attempt->quiz->time_limit_sec;

        return view('pages.student.quiz-attempt', compact('attempt', 'quiz', 'timeLimit'));
    }

    /**
     * Nộp bài — lưu tất cả đáp án rồi tính điểm.
     */
    public function submit(Request $request, int $attemptId)
    {
        $attempt = $this->attemptService->findById($attemptId);

        if ($attempt->user_id !== session('user_id')) {
            abort(403);
        }

        // answers = [['question_id' => 1, 'selected_option_id' => 3], ...]
        $answers = $request->validate([
            'answers'                      => 'required|array',
            'answers.*.question_id'        => 'required|integer',
            'answers.*.selected_option_id' => 'nullable|integer',
            'answers.*.answer_text'        => 'nullable|string',
        ])['answers'];

        $this->answerService->saveBulk($attemptId, $answers);
        $this->attemptService->submit($attemptId);

        return redirect()->route('student.quiz.result', $attemptId);
    }

    /**
     * Trang kết quả sau khi nộp bài.
     */
    public function result(int $attemptId)
    {
        $attempt = $this->attemptService->findById($attemptId);

        if ($attempt->user_id !== session('user_id')) {
            abort(403);
        }

        $answers   = $this->answerService->getByAttempt($attemptId);
        $correct   = $this->answerService->countCorrect($attemptId);
        $total     = $answers->count();
        $bestScore = $this->attemptService->getBestScore(session('user_id'), $attempt->quiz_id);

        return view('pages.student.quiz-result', compact(
            'attempt', 'answers', 'correct', 'total', 'bestScore'
        ));
    }
}

?>