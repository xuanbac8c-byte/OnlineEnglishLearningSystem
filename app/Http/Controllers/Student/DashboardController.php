<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Services\Interfaces\ILessonProgressService;

class DashboardController extends Controller
{
    public function __construct(
        protected ILessonProgressService $progressService
    ) {}

    public function index()
    {
        $userId = session('user_id');

        // Enrollments với course info
        $enrollments = Enrollment::with(['course.user', 'course.sections'])
            ->where('user_id', $userId)
            ->latest('enrolled_at')
            ->get();

        // Thêm progress % vào mỗi enrollment
        $my_courses = $enrollments->take(6)->map(function ($enrollment) use ($userId) {
            $enrollment->progress_percent = $this->progressService
                ->getCourseProgress($userId, $enrollment->course_id);
            return $enrollment;
        });

        // Khóa học đang học dở (progress > 0 và < 100)
        $continue_course   = null;
        $continue_progress = 0;
        foreach ($enrollments as $e) {
            $p = $this->progressService->getCourseProgress($userId, $e->course_id);
            if ($p > 0 && $p < 100) {
                $continue_course   = $e->course;
                $continue_progress = round($p);
                break;
            }
        }

        // Quiz attempts
        $quiz_attempts = QuizAttempt::with('quiz')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Certificates
        $certificates = Certificate::with('course')
            ->where('user_id', $userId)
            ->latest('issued_at')
            ->take(5)
            ->get();

        // Stats
        $allCourseIds      = $enrollments->pluck('course_id');
        $completedCourseIds = $enrollments->filter(fn($e) =>
            $this->progressService->getCourseProgress($userId, $e->course_id) >= 100
        )->pluck('course_id');

        $stats = [
            'enrolled_courses'  => $enrollments->count(),
            'in_progress'       => $enrollments->count() - $completedCourseIds->count(),
            'completed_courses' => $completedCourseIds->count(),
            'completed_lessons' => LessonProgress::where('user_id', $userId)
                                    ->where('is_completed', true)->count(),
            'certificates'      => $certificates->count(),
            'avg_quiz_score'    => round(QuizAttempt::where('user_id', $userId)->avg('score') ?? 0),
            'quiz_passed'       => QuizAttempt::where('user_id', $userId)->where('is_passed', true)->count(),
            'streak_days'       => $this->calcStreak($userId),
        ];

        return view('pages.dashboard', compact(
            'stats', 'my_courses', 'quiz_attempts',
            'certificates', 'continue_course', 'continue_progress'
        ));
    }

    public function myCourses()
    {
        $userId = session('user_id');

        $enrollments = Enrollment::with(['course.user'])
            ->where('user_id', $userId)
            ->latest('enrolled_at')
            ->paginate(12);

        // Gán progress
        $enrollments->getCollection()->transform(function ($e) use ($userId) {
            $e->progress_percent = $this->progressService
                ->getCourseProgress($userId, $e->course_id);
            return $e;
        });

        return view('pages.student.my-courses', compact('enrollments'));
    }

    // ── Private helpers ─────────────────────────────────────

    private function calcStreak(int $userId): int
    {
        $dates = LessonProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->pluck('completed_at')
            ->map(fn($d) => $d->toDateString())
            ->unique()
            ->values();

        $streak = 0;
        $today  = now()->toDateString();

        foreach ($dates as $i => $date) {
            $expected = now()->subDays($i)->toDateString();
            if ($date === $expected) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }
}

?>