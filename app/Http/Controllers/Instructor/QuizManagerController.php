<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Services\Interfaces\IQuizOptionService;
use App\Services\Interfaces\IQuizService;
use Illuminate\Http\Request;

class QuizManagerController extends Controller
{
    public function __construct(
        protected IQuizService       $quizService,
        protected IQuizOptionService $optionService,
    ) {}

    public function show(int $quizId)
    {
        $quiz = Quiz::with('quizQuestions.quizOptions')->findOrFail($quizId);
        return view('pages.instructor.quiz-editor', compact('quiz'));
    }

    public function store(Request $request, int $lessonId)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'pass_score'     => 'required|numeric|min:0|max:100',
            'time_limit_sec' => 'nullable|integer|min:0',
            'max_attempts'   => 'required|integer|min:1',
        ]);

        $quiz = $this->quizService->create(array_merge($data, ['lesson_id' => $lessonId]));

        return redirect()->route('instructor.quiz.show', $quiz->quiz_id)
            ->with('success', 'Tạo quiz thành công.');
    }

    public function update(Request $request, int $quizId)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'pass_score'     => 'required|numeric|min:0|max:100',
            'time_limit_sec' => 'nullable|integer|min:0',
            'max_attempts'   => 'required|integer|min:1',
        ]);

        $this->quizService->update($quizId, $data);
        return back()->with('success', 'Đã cập nhật quiz.');
    }

    public function destroy(int $quizId)
    {
        $this->quizService->delete($quizId);
        return back()->with('success', 'Đã xoá quiz.');
    }

    public function storeQuestion(Request $request, int $quizId)
    {
        $data = $request->validate([
            'question'      => 'required|string',
            'question_type' => 'required|in:single_choice,multiple_choice,fill_blank,true_false',
            'points'        => 'required|integer|min:1',
        ]);

        QuizQuestion::create(array_merge($data, ['quiz_id' => $quizId]));

        return back()->with('success', 'Đã thêm câu hỏi.');
    }

    public function updateQuestion(Request $request, int $questionId)
    {
        $data = $request->validate([
            'question'      => 'required|string',
            'question_type' => 'required|in:single_choice,multiple_choice,fill_blank,true_false',
            'points'        => 'required|integer|min:1',
        ]);

        QuizQuestion::findOrFail($questionId)->update($data);
        return back()->with('success', 'Đã cập nhật câu hỏi.');
    }

    public function destroyQuestion(int $questionId)
    {
        QuizQuestion::findOrFail($questionId)->delete();
        return back()->with('success', 'Đã xoá câu hỏi.');
    }

    public function storeOption(Request $request, int $questionId)
    {
        $data = $request->validate([
            'option_text' => 'required|string|max:500',
            'is_correct'  => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $this->optionService->create(array_merge($data, ['question_id' => $questionId]));
        return back()->with('success', 'Đã thêm đáp án.');
    }

    public function updateOption(Request $request, int $optionId)
    {
        $data = $request->validate([
            'option_text' => 'required|string|max:500',
            'is_correct'  => 'nullable|boolean',
        ]);

        $this->optionService->update($optionId, $data);
        return back()->with('success', 'Đã cập nhật đáp án.');
    }

    public function destroyOption(int $optionId)
    {
        $this->optionService->delete($optionId);
        return back()->with('success', 'Đã xoá đáp án.');
    }

    public function setCorrectOption(int $optionId)
    {
        $this->optionService->setCorrect($optionId);
        return response()->json(['ok' => true]);
    }
}

?>