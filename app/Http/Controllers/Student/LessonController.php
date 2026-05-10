<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use ICertificateService;
use IEnrollmentService;
use ILessonProgressService;
use ILessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(
        protected ILessonService         $lessonService,
        protected ILessonProgressService $progressService,
        protected IEnrollmentService     $enrollmentService,
        protected ICertificateService    $certService,
    ) {}

    /**
     * Xem nội dung bài học.
     */
    public function show(int $courseId, int $lessonId)
    {
        $userId = session('user_id');

        // Kiểm tra đã enroll chưa
        if (!$this->enrollmentService->isEnrolled($userId, $courseId)) {
            return redirect()->route('courses.show', $courseId)
                ->withErrors('Bạn cần đăng ký khóa học trước khi học bài này.');
        }

        $lesson   = $this->lessonService->findById($lessonId);
        $progress = $this->progressService->getProgress($userId, $lessonId);

        // Danh sách lesson hoàn thành (để highlight sidebar)
        $completedIds = $this->progressService
            ->getCompletedLessons($userId, $courseId)
            ->pluck('lesson_id');

        $courseProgress = $this->progressService->getCourseProgress($userId, $courseId);

        return view('pages.student.lesson', compact(
            'lesson', 'progress', 'completedIds', 'courseProgress', 'courseId'
        ));
    }

    /**
     * Cập nhật % xem video (gọi bằng AJAX).
     */
    public function updateProgress(Request $request, int $lessonId)
    {
        $data = $request->validate([
            'percent' => 'required|numeric|min:0|max:100',
        ]);

        $progress = $this->progressService->updateProgress(
            session('user_id'),
            $lessonId,
            $data['percent']
        );

        return response()->json([
            'is_completed' => $progress->is_completed,
            'percent'      => $progress->completed_percent,
        ]);
    }

    /**
     * Đánh dấu bài học hoàn thành.
     */
    public function markComplete(Request $request, int $courseId, int $lessonId)
    {
        $userId = session('user_id');

        $this->progressService->markCompleted($userId, $lessonId);

        // Kiểm tra điều kiện nhận chứng chỉ
        if ($this->certService->canReceive($userId, $courseId)) {
            $cert = $this->certService->issue($userId, $courseId);
            return back()->with('cert_issued', $cert->cert_code);
        }

        return back()->with('success', 'Đã hoàn thành bài học!');
    }
}

?>