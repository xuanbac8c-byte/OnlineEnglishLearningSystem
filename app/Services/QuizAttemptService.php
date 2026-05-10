<?php

namespace App\Services;

use App\Models\QuizAttempt;
use App\Services\Interfaces\IQuizAttemptService;
use Illuminate\Support\Collection;

class QuizAttemptService implements IQuizAttemptService
{
    public function start(int $userId, int $quizId): QuizAttempt
    {
        $attemptNumber = $this->getAttemptNumber($userId, $quizId) + 1;

        return QuizAttempt::create([
            'user_id'        => $userId,
            'quiz_id'        => $quizId,
            'attempt_number' => $attemptNumber,
            'started_at'     => now(),
            'is_passed'      => false,
            'score'          => 0,
        ]);
    }

    public function submit(int $attemptId): QuizAttempt
    {
        $attempt  = QuizAttempt::with('quiz')->findOrFail($attemptId);
        $score    = $this->calculateScore($attemptId);
        $isPassed = $score >= $attempt->quiz->pass_score;

        $attempt->update([
            'score'        => $score,
            'is_passed'    => $isPassed,
            'submitted_at' => now(),
        ]);

        return $attempt;
    }

    // Tính từ points_earned đã lưu sẵn — không query DB thêm lần nữa
    public function calculateScore(int $attemptId): float
    {
        return (float) \App\Models\QuizAnswer::where('quiz_attempt_id', $attemptId)
            ->sum('points_earned');
    }

    public function getByUser(int $userId): Collection
    {
        return QuizAttempt::where('user_id', $userId)->with('quiz')->latest()->get();
    }

    public function getByQuiz(int $quizId): Collection
    {
        return QuizAttempt::where('quiz_id', $quizId)->with('user')->latest()->get();
    }

    public function findById(int $id): QuizAttempt
    {
        return QuizAttempt::with(['quiz', 'quizAnswers'])->findOrFail($id);
    }

    public function getAttemptNumber(int $userId, int $quizId): int
    {
        return QuizAttempt::where('user_id', $userId)->where('quiz_id', $quizId)->count();
    }

    public function getBestScore(int $userId, int $quizId): float
    {
        return (float) (QuizAttempt::where('user_id', $userId)->where('quiz_id', $quizId)->max('score') ?? 0);
    }
}

?>