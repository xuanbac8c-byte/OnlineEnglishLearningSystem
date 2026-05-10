<?php

use App\Models\QuizOption;
use Ramsey\Collection\Collection;

    interface IQuizOptionService {
    public function getByQuestion(int $questionId): Collection;
    public function findById(int $id): QuizOption;
    public function create(array $data): QuizOption;
    public function update(int $id, array $data): QuizOption;
    public function delete(int $id): bool;
    public function setCorrect(int $optionId): QuizOption;  // đánh dấu đáp án đúng
    public function getCorrectOptions(int $questionId): Collection;
}
?>