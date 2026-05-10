<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::with('user')
            ->withCount('sections')
            ->withAvg('courseReviews', 'rating')
            ->where('is_published', true)
            ->latest()
            ->take(8)
            ->get();

        return view('pages.home', compact('courses'));
    }
}

?>