<?php

    use App\Models\QuizAnswer;
    use Illuminate\Support\Collection;

    interface IQuizAnswerService {
    public function saveAnswer(int $attemptId, int $questionId, array $data): QuizAnswer;
    public function saveBulk(int $attemptId, array $answers): Collection; // submit cả bài
    public function getByAttempt(int $attemptId): Collection;
    public function evaluate(int $answerId): QuizAnswer; // chấm đúng/sai
    public function countCorrect(int $attemptId): int;
}
?>