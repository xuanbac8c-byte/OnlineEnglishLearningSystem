<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Enums\UserRole;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_courses'     => Course::count(),
            'total_revenue'     => Payment::where('status', 'paid')->sum('amount'),
            'total_enrollments' => Enrollment::count(),
            'student_count'     => User::where('role', UserRole::student)->count(),
            'instructor_count'  => User::where('role', UserRole::instructor)->count(),
            'admin_count'       => User::where('role', UserRole::admin)->count(),
        ];

        $recent_users = User::latest()->take(8)->get();

        $recent_payments = Payment::with(['user', 'course'])
            ->where('status', 'paid')
            ->latest()
            ->take(8)
            ->get();

        $top_courses = Course::with('user')
            ->withCount(['enrollments', 'sections'])
            ->withAvg('courseReviews', 'rating')
            ->where('is_published', true)
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        return view('pages.admin.dashboard', compact(
            'stats', 'recent_users', 'recent_payments', 'top_courses'
        ));
    }

    public function users()
    {
        // Delegate to AdminUser — redirect về đúng route
        return redirect()->route('admin.users');
    }

    public function courses()
    {
        // Delegate to AdminCourse — redirect về đúng route
        return redirect()->route('admin.courses');
    }
}

?>