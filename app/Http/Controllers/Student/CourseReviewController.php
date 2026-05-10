<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use ICourseReviewService;
use IEnrollmentService;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    public function __construct(
        protected ICourseReviewService $reviewService,
        protected IEnrollmentService   $enrollmentService,
    ) {}

    public function store(Request $request, int $courseId)
    {
        $userId = session('user_id');

        if (!$this->enrollmentService->isEnrolled($userId, $courseId)) {
            return back()->withErrors('Bạn cần đăng ký khóa học trước khi đánh giá.');
        }

        if ($this->reviewService->hasReviewed($userId, $courseId)) {
            return back()->withErrors('Bạn đã đánh giá khóa học này rồi.');
        }

        $data = $request->validate([
            'rating'  => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $this->reviewService->create($userId, $courseId, $data);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

    public function update(Request $request, int $reviewId)
    {
        $data = $request->validate([
            'rating'  => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $this->reviewService->update($reviewId, $data);

        return back()->with('success', 'Đã cập nhật đánh giá.');
    }

    public function destroy(int $reviewId)
    {
        $this->reviewService->delete($reviewId);
        return back()->with('success', 'Đã xoá đánh giá.');
    }
}

?>