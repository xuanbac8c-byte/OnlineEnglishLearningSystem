<?php

namespace App\Services;

use App\Models\QuizAttempt;
use App\Models\QuizOption;

use Illuminate\Support\Collection;
use IQuizAttemptService;

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
        $attempt = QuizAttempt::with('quiz')->findOrFail($attemptId);
        $score   = $this->calculateScore($attemptId);
        $isPassed = $score >= $attempt->quiz->pass_score;

        $attempt->update([
            'score'        => $score,
            'is_passed'    => $isPassed,
            'submitted_at' => now(),
        ]);

        return $attempt;
    }

    public function calculateScore(int $attemptId): float
    {
        $attempt = QuizAttempt::with('quizAnswers.question')->findOrFail($attemptId);
        $total   = 0;

        foreach ($attempt->quizAnswers as $answer) {
            $isCorrect = false;

            if ($answer->selected_option_id) {
                $isCorrect = QuizOption::where('quiz_option_id', $answer->selected_option_id)
                    ->where('is_correct', true)
                    ->exists();
            } elseif ($answer->answer_text) {
                $isCorrect = QuizOption::where('question_id', $answer->question_id)
                    ->where('is_correct', true)
                    ->whereRaw('LOWER(option_text) = LOWER(?)', [$answer->answer_text])
                    ->exists();
            }

            if ($isCorrect) {
                $total += $answer->question->points ?? 1;
            }
        }

        return (float) $total;
    }

    public function getByUser(int $userId): Collection
    {
        return QuizAttempt::where('user_id', $userId)
            ->with('quiz')
            ->latest()
            ->get();
    }

    public function getByQuiz(int $quizId): Collection
    {
        return QuizAttempt::where('quiz_id', $quizId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function findById(int $id): QuizAttempt
    {
        return QuizAttempt::with(['quiz', 'quizAnswers'])->findOrFail($id);
    }

    public function getAttemptNumber(int $userId, int $quizId): int
    {
        return QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->count();
    }

    public function getBestScore(int $userId, int $quizId): float
    {
        return (float) (QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->max('score') ?? 0);
    }
}

?>