<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;

// Home
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

// Courses
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{id}', [CourseController::class, 'show']);

// Blog
Route::view('/blog', 'pages.blog');

Route::get('/blog/{id}', function ($id) {
    return view('pages.blog-detail', ['postId' => $id]);
});

// About
Route::view('/about', 'pages.about');

// Instructors
Route::view('/contact', 'pages.instructor');
Route::view('/instructors', 'pages.instructor');

Route::get('/instructors/{id}', function ($id) {
    return view('pages.instructor-detail', ['instructorId' => $id]);
});

// Auth
Route::view('/login', 'pages.login')->name('login');
Route::view('/register', 'pages.register')->name('register');

Route::post('/register', [UserController::class, 'register']);

// Users
Route::resource('users', UserController::class);
// Users Role Admin
Route::middleware(['auth', 'admin'])
    ->group(function (){
        Route::get('/admin/users', [
            UserController::class, 'index'
        ]);
    });