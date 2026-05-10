<?php
    namespace App\Services;

use App\Models\QuizAttempt;
use App\Models\Quiz;

use Illuminate\Support\Collection;
use IQuizAnswerService;

class QuizAttemptService implements  IQuizAnswerService
{
    public function start(int $userId, int $quizId): QuizAttempt 
    {
        $attemptNumber = $this->getAttemptNumber($userId, $quizId) + 1;

        return QuizAttempt::create([
            'user_id' => $userId,
            'quiz_id' => $quizId,
            'attempt_number' => $attemptNumber,
            'started_at' => now(),
            'is_passed' => false,
            'score' => 0
        ]);
    }

    public function submit(int $attemptId): QuizAttempt 
    {
        $attempt = QuizAttempt::findOrFail($attemptId);
        $quiz = $attempt->quiz;
        
        $score = $this->calculateScore($attemptId);
        $isPassed = $score >= $quiz->pass_score;

        $attempt->update([
            'score' => $score,
            'is_passed' => $isPassed,
            'submitted_at' => now()
        ]);

        return $attempt;
    }

    public function calculateScore(int $attemptId): float 
    {
        $attempt = QuizAttempt::with('answers.question')->findOrFail($attemptId);
        $totalScore = 0;

        foreach ($attempt->answers as $answer) {
            // Logic: Nếu answer_text khớp với quiz_options có is_correct = true
            $isCorrect = \App\Models\QuizOption::where('question_id', $answer->question_id)
                ->where('is_correct', true)
                ->where('option_text', $answer->answer_text)
                ->exists();

            if ($isCorrect) {
                $totalScore += $answer->question->points;
            }
        }

        return $totalScore;
    }

    public function getAttemptNumber(int $userId, int $quizId): int 
    {
        return QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->count();
    }

    public function getBestScore(int $userId, int $quizId): float 
    {
        return (float) QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->max('score') ?? 0;
    }
    
    // ... các hàm findById, getByUser triển khai đơn giản bằng Eloquent
}
?>