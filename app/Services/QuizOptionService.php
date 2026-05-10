<?php

namespace App\Services;

use App\Models\QuizOption;
use Illuminate\Support\Collection;
use IQuizOptionService;

class QuizOptionService implements IQuizOptionService
{
    public function getByQuestion(int $questionId): Collection
    {
        return QuizOption::where('question_id', $questionId)
            ->orderBy('sort_order')
            ->get();
    }

    public function findById(int $id): QuizOption
    {
        return QuizOption::findOrFail($id);
    }

    public function create(array $data): QuizOption
    {
        return QuizOption::create([
            'question_id' => $data['question_id'],
            'option_text' => $data['option_text'],
            'is_correct'  => $data['is_correct'] ?? false,
            'sort_order'  => $data['sort_order'] ?? 0,
        ]);
    }

    public function update(int $id, array $data): QuizOption
    {
        $option = QuizOption::findOrFail($id);
        $option->update([
            'option_text' => $data['option_text'] ?? $option->option_text,
            'is_correct'  => $data['is_correct'] ?? $option->is_correct,
            'sort_order'  => $data['sort_order'] ?? $option->sort_order,
        ]);
        return $option;
    }

    public function delete(int $id): bool
    {
        return QuizOption::findOrFail($id)->delete();
    }

    public function setCorrect(int $optionId): QuizOption
    {
        $option = QuizOption::findOrFail($optionId);

        // For single-choice: unmark all other options in the same question
        QuizOption::where('question_id', $option->question_id)
            ->update(['is_correct' => false]);

        $option->update(['is_correct' => true]);
        return $option;
    }

    public function getCorrectOptions(int $questionId): Collection
    {
        return QuizOption::where('question_id', $questionId)
            ->where('is_correct', true)
            ->get();
    }
}

?>