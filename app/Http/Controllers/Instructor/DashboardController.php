<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = session('user_id');

        $my_courses = Course::where('teacher_id', $teacherId)
            ->withCount(['enrollments', 'sections'])
            ->withAvg('courseReviews', 'rating')
            ->latest()
            ->take(6)
            ->get();

        $allCourseIds = Course::where('teacher_id', $teacherId)->pluck('course_id');

        $stats = [
            'my_courses'         => Course::where('teacher_id', $teacherId)->count(),
            'published_courses'  => Course::where('teacher_id', $teacherId)->where('is_published', true)->count(),
            'total_students'     => Enrollment::whereIn('course_id', $allCourseIds)->distinct('user_id')->count('user_id'),
            'new_students_month' => Enrollment::whereIn('course_id', $allCourseIds)
                                        ->where('enrolled_at', '>=', now()->startOfMonth())
                                        ->count(),
            'avg_rating'         => round(CourseReview::whereIn('course_id', $allCourseIds)->avg('rating') ?? 0, 1),
            'total_reviews'      => CourseReview::whereIn('course_id', $allCourseIds)->count(),
            'total_revenue'      => Payment::whereIn('course_id', $allCourseIds)->where('status', 'paid')->sum('amount'),
            'month_revenue'      => Payment::whereIn('course_id', $allCourseIds)
                                        ->where('status', 'paid')
                                        ->where('paid_at', '>=', now()->startOfMonth())
                                        ->sum('amount'),
        ];

        $recent_reviews = CourseReview::with(['user', 'course'])
            ->whereIn('course_id', $allCourseIds)
            ->latest()
            ->take(4)
            ->get();

        $recent_enrollments = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $allCourseIds)
            ->latest('enrolled_at')
            ->take(8)
            ->get();

        return view('pages.instructor.dashboard', compact(
            'stats', 'my_courses', 'recent_reviews', 'recent_enrollments'
        ));
    }

    public function courses()
    {
        $courses = Course::where('teacher_id', session('user_id')) // Fix: session thay Auth::id()
            ->withCount(['enrollments', 'sections'])
            ->withAvg('courseReviews', 'rating')
            ->latest()
            ->paginate(12);

        return view('pages.instructor.courses', compact('courses'));
    }

    public function createCourse()
    {
        return view('pages.instructor.create-course');
    }
}

?>