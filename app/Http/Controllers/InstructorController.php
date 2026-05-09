<?php
namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;

class InstructorController extends Controller {

    public function index() {
        $instructors = User::where('role', UserRole::instructor)
            ->with(['courses'])
            ->paginate(9);

        return view('pages.instructors', compact('instructors'));
    }

    public function show($id) {
        $instructor = User::where('role', UserRole::instructor)
            ->with(['courses' => fn($q) => $q->where('is_published', true)])
            ->findOrFail($id);

        return view('pages.instructor-detail', compact('instructor'));
    }
}