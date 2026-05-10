<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\Interfaces\IQuizService;
use Illuminate\Support\Collection;

class QuizService implements IQuizService
{
    public function getByLesson(int $lessonId): Collection
    {
        return Quiz::where('lesson_id', $lessonId)->get();
    }

    public function findById(int $id): Quiz
    {
        return Quiz::findOrFail($id);
    }

    public function create(array $data): Quiz
    {
        return Quiz::create([
            'lesson_id'      => $data['lesson_id'],
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'pass_score'     => $data['pass_score'] ?? 0,
            'time_limit_sec' => $data['time_limit_sec'] ?? null,
            'max_attempts'   => $data['max_attempts'] ?? 1,
        ]);
    }

    public function update(int $id, array $data): Quiz
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->update([
            'title'          => $data['title'] ?? $quiz->title,
            'description'    => $data['description'] ?? $quiz->description,
            'pass_score'     => $data['pass_score'] ?? $quiz->pass_score,
            'time_limit_sec' => $data['time_limit_sec'] ?? $quiz->time_limit_sec,
            'max_attempts'   => $data['max_attempts'] ?? $quiz->max_attempts,
        ]);
        return $quiz;
    }

    public function delete(int $id): bool
    {
        return Quiz::findOrFail($id)->delete();
    }

    public function canAttempt(int $userId, int $quizId): bool
    {
        $quiz = Quiz::findOrFail($quizId);

        // unlimited attempts
        if ($quiz->max_attempts <= 0) {
            return true;
        }

        $attemptCount = QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->count();

        return $attemptCount < $quiz->max_attempts;
    }
}

?>