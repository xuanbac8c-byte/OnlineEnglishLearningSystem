<?php

    use App\Models\Quiz;
    use Illuminate\Support\Collection;

    interface IQuizService {
    public function getByLesson(int $lessonId): Collection;
    public function findById(int $id): Quiz;
    public function create(array $data): Quiz;
    public function update(int $id, array $data): Quiz;
    public function delete(int $id): bool;
    public function canAttempt(int $userId, int $quizId): bool; // check max_attempts
}
?>