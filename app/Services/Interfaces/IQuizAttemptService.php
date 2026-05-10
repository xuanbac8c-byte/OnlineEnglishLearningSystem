<?php

    use App\Models\QuizAttempt;
    use Illuminate\Support\Collection;

    interface IQuizAttemptService {
    public function start(int $userId, int $quizId): QuizAttempt;
    public function submit(int $attemptId): QuizAttempt; // tính điểm, ghi submitted_at
    public function calculateScore(int $attemptId): float;
    public function getByUser(int $userId): Collection;
    public function getByQuiz(int $quizId): Collection;
    public function findById(int $id): QuizAttempt;
    public function getAttemptNumber(int $userId, int $quizId): int;
    public function getBestScore(int $userId, int $quizId): float;
}
?>