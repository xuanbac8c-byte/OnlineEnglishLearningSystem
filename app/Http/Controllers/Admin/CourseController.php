<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use ICourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        protected ICourseService $courseService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['level', 'keyword']);
        $courses = $this->courseService->getAll($filters, 20);

        return view('pages.admin.courses', compact('courses'));
    }

    public function show(int $courseId)
    {
        $course = $this->courseService->getWithDetails($courseId);
        return view('pages.admin.course-detail', compact('course'));
    }

    public function publish(int $courseId)
    {
        $this->courseService->publish($courseId);
        return back()->with('success', 'Khóa học đã được xuất bản.');
    }

    public function unpublish(int $courseId)
    {
        $this->courseService->unpublish($courseId);
        return back()->with('success', 'Đã ẩn khóa học.');
    }

    public function destroy(int $courseId)
    {
        $this->courseService->delete($courseId);
        return redirect()->route('admin.courses')
            ->with('success', 'Đã xoá khóa học.');
    }
}

?>