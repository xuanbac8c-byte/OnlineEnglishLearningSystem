<?php

namespace App\Services;

use App\Models\QuizAnswer;
use App\Models\QuizOption;
use Illuminate\Support\Collection;
use IQuizAnswerService;

class QuizAnswerService implements IQuizAnswerService
{
    public function saveAnswer(int $attemptId, int $questionId, array $data): QuizAnswer
    {
        $isCorrect = $this->checkCorrect($questionId, $data);

        return QuizAnswer::updateOrCreate(
            ['quiz_attempt_id' => $attemptId, 'question_id' => $questionId],
            [
                'selected_option_id' => $data['selected_option_id'] ?? null,
                'answer_text'        => $data['answer_text'] ?? null,
                'is_correct'         => $isCorrect,
                'points_earned'      => $isCorrect ? ($data['points'] ?? 1) : 0,
            ]
        );
    }

    public function saveBulk(int $attemptId, array $answers): Collection
    {
        $saved = collect();
        foreach ($answers as $answer) {
            $saved->push($this->saveAnswer($attemptId, $answer['question_id'], $answer));
        }
        return $saved;
    }

    public function getByAttempt(int $attemptId): Collection
    {
        return QuizAnswer::with(['question', 'selectedOption'])
            ->where('quiz_attempt_id', $attemptId)
            ->get();
    }

    public function evaluate(int $answerId): QuizAnswer
    {
        $answer = QuizAnswer::with('question')->findOrFail($answerId);

        $isCorrect = $this->checkCorrect($answer->question_id, [
            'selected_option_id' => $answer->selected_option_id,
            'answer_text'        => $answer->answer_text,
        ]);

        $answer->update([
            'is_correct'    => $isCorrect,
            'points_earned' => $isCorrect ? ($answer->question->points ?? 1) : 0,
        ]);

        return $answer;
    }

    public function countCorrect(int $attemptId): int
    {
        return QuizAnswer::where('quiz_attempt_id', $attemptId)
            ->where('is_correct', true)
            ->count();
    }

    // ── Private helper ──────────────────────────────────────

    private function checkCorrect(int $questionId, array $data): bool
    {
        if (!empty($data['selected_option_id'])) {
            return QuizOption::where('quiz_option_id', $data['selected_option_id'])
                ->where('is_correct', true)
                ->exists();
        }

        if (!empty($data['answer_text'])) {
            return QuizOption::where('question_id', $questionId)
                ->where('is_correct', true)
                ->whereRaw('LOWER(option_text) = LOWER(?)', [$data['answer_text']])
                ->exists();
        }

        return false;
    }
}

?>