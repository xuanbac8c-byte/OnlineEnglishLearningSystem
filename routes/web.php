<?php

use Illuminate\Support\Facades\Route;

// ── Public Controllers ───────────────────────────────────────
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RoadMapController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;

// ── Auth ─────────────────────────────────────────────────────
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;

// ── Student ──────────────────────────────────────────────────
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\LessonController as StudentLesson;
use App\Http\Controllers\Student\QuizController as StudentQuiz;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\CourseReviewController;
use App\Http\Controllers\Student\CertificateController;

// ── Instructor ───────────────────────────────────────────────
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboard;
use App\Http\Controllers\Instructor\CourseManagerController;
use App\Http\Controllers\Instructor\QuizManagerController;

// ── Admin ────────────────────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CourseController as AdminCourse;

// ============================================================
// PUBLIC ROUTES
// ============================================================

Route::get('/',        [HomeController::class, 'index'])->name('home');
Route::get('/home',    [HomeController::class, 'index']);
Route::get('/about',   [AboutController::class, 'index'])->name('about');
Route::get('/roadmap', [RoadMapController::class, 'index'])->name('roadmap');

Route::get('/courses',      [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/instructors',      [InstructorController::class, 'index'])->name('instructors.index');
Route::get('/instructors/{id}', [InstructorController::class, 'show'])->name('instructors.show');

Route::get('/blog',        [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Certificate verify (public)
Route::get('/verify',        [CertificateController::class, 'verify'])->name('certificate.verify');
Route::get('/verify/{code}', [CertificateController::class, 'show'])->name('certificate.show');

// ============================================================
// AUTH ROUTES
// ============================================================

Route::middleware('guest_session')->group(function () {
    Route::get('/login',    [LoginController::class, 'showForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================================
// AUTHENTICATED ROUTES
// ============================================================

Route::middleware('auth_session')->group(function () {

    // ── Profile ──────────────────────────────────────────────
    Route::get('/profile',                   [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',              [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',                   [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar',           [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/change-password',  [ProfileController::class, 'changePassword'])->name('profile.password');

    // ── Payment callback (shared) ────────────────────────────
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

    // ============================================================
    // STUDENT ROUTES  (middleware: role:student)
    // ============================================================
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {

        Route::get('/dashboard',   [StudentDashboard::class, 'index'])->name('dashboard');
        Route::get('/my-courses',  [StudentDashboard::class, 'myCourses'])->name('my-courses');

        // Enrollment
        Route::post('/enroll/{courseId}',   [EnrollmentController::class, 'enroll'])->name('enroll');
        Route::delete('/unenroll/{courseId}',[EnrollmentController::class, 'unenroll'])->name('unenroll');

        // Lesson
        Route::get('/courses/{courseId}/lessons/{lessonId}',
            [StudentLesson::class, 'show'])->name('lesson.show');
        Route::post('/lessons/{lessonId}/progress',
            [StudentLesson::class, 'updateProgress'])->name('lesson.progress');
        Route::post('/courses/{courseId}/lessons/{lessonId}/complete',
            [StudentLesson::class, 'markComplete'])->name('lesson.complete');

        // Quiz
        Route::get('/quiz/{quizId}',          [StudentQuiz::class, 'show'])->name('quiz.show');
        Route::post('/quiz/{quizId}/start',   [StudentQuiz::class, 'start'])->name('quiz.start');
        Route::get('/quiz/attempt/{attemptId}',[StudentQuiz::class, 'attempt'])->name('quiz.attempt');
        Route::post('/quiz/attempt/{attemptId}/submit',
            [StudentQuiz::class, 'submit'])->name('quiz.submit');
        Route::get('/quiz/result/{attemptId}', [StudentQuiz::class, 'result'])->name('quiz.result');

        // Payment
        Route::get('/checkout/{courseId}',    [PaymentController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/{courseId}',   [PaymentController::class, 'createPayment'])->name('payment.create');
        Route::get('/payment/history',        [PaymentController::class, 'history'])->name('payment.history');

        // Review
        Route::post('/courses/{courseId}/review',        [CourseReviewController::class, 'store'])->name('review.store');
        Route::put('/reviews/{reviewId}',                [CourseReviewController::class, 'update'])->name('review.update');
        Route::delete('/reviews/{reviewId}',             [CourseReviewController::class, 'destroy'])->name('review.destroy');

        // Certificates
        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates');
    });

    // ============================================================
    // INSTRUCTOR ROUTES  (middleware: role:instructor)
    // ============================================================
    Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function () {

        Route::get('/dashboard', [InstructorDashboard::class, 'index'])->name('dashboard');
        Route::get('/courses',   [InstructorDashboard::class, 'courses'])->name('courses');

        // Course CRUD
        Route::get('/courses/create',          [CourseManagerController::class, 'create'])->name('create-course');
        Route::post('/courses',                [CourseManagerController::class, 'store'])->name('courses.store');
        Route::get('/courses/{courseId}/edit', [CourseManagerController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{courseId}',      [CourseManagerController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{courseId}',   [CourseManagerController::class, 'destroy'])->name('courses.destroy');
        Route::post('/courses/{courseId}/publish',   [CourseManagerController::class, 'publish'])->name('courses.publish');
        Route::post('/courses/{courseId}/unpublish', [CourseManagerController::class, 'unpublish'])->name('courses.unpublish');

        // Section
        Route::post('/courses/{courseId}/sections',      [CourseManagerController::class, 'storeSection'])->name('sections.store');
        Route::put('/sections/{sectionId}',              [CourseManagerController::class, 'updateSection'])->name('sections.update');
        Route::delete('/sections/{sectionId}',           [CourseManagerController::class, 'destroySection'])->name('sections.destroy');
        Route::post('/courses/{courseId}/sections/reorder',
            [CourseManagerController::class, 'reorderSections'])->name('sections.reorder');

        // Lesson
        Route::post('/sections/{sectionId}/lessons',     [CourseManagerController::class, 'storeLesson'])->name('lessons.store');
        Route::put('/lessons/{lessonId}',                [CourseManagerController::class, 'updateLesson'])->name('lessons.update');
        Route::delete('/lessons/{lessonId}',             [CourseManagerController::class, 'destroyLesson'])->name('lessons.destroy');
        Route::post('/sections/{sectionId}/lessons/reorder',
            [CourseManagerController::class, 'reorderLessons'])->name('lessons.reorder');

        // Quiz
        Route::get('/quiz/{quizId}',                       [QuizManagerController::class, 'show'])->name('quiz.show');
        Route::post('/lessons/{lessonId}/quiz',            [QuizManagerController::class, 'store'])->name('quiz.store');
        Route::put('/quiz/{quizId}',                       [QuizManagerController::class, 'update'])->name('quiz.update');
        Route::delete('/quiz/{quizId}',                    [QuizManagerController::class, 'destroy'])->name('quiz.destroy');

        // Question
        Route::post('/quiz/{quizId}/questions',            [QuizManagerController::class, 'storeQuestion'])->name('question.store');
        Route::put('/questions/{questionId}',              [QuizManagerController::class, 'updateQuestion'])->name('question.update');
        Route::delete('/questions/{questionId}',           [QuizManagerController::class, 'destroyQuestion'])->name('question.destroy');

        // Option
        Route::post('/questions/{questionId}/options',     [QuizManagerController::class, 'storeOption'])->name('option.store');
        Route::put('/options/{optionId}',                  [QuizManagerController::class, 'updateOption'])->name('option.update');
        Route::delete('/options/{optionId}',               [QuizManagerController::class, 'destroyOption'])->name('option.destroy');
        Route::post('/options/{optionId}/set-correct',     [QuizManagerController::class, 'setCorrectOption'])->name('option.set-correct');
    });

    // ============================================================
    // ADMIN ROUTES  (middleware: role:admin)
    // ============================================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users',                  [AdminUser::class, 'index'])->name('users');
        Route::get('/users/{userId}',         [AdminUser::class, 'show'])->name('users.show');
        Route::get('/users/{userId}/edit',    [AdminUser::class, 'edit'])->name('users.edit');
        Route::put('/users/{userId}',         [AdminUser::class, 'update'])->name('users.update');
        Route::post('/users/{userId}/reset-password',
            [AdminUser::class, 'resetPassword'])->name('users.reset-password');
        Route::delete('/users/{userId}',      [AdminUser::class, 'destroy'])->name('users.destroy');

        // Courses
        Route::get('/courses',                [AdminCourse::class, 'index'])->name('courses');
        Route::get('/courses/{courseId}',     [AdminCourse::class, 'show'])->name('courses.show');
        Route::post('/courses/{courseId}/publish',   [AdminCourse::class, 'publish'])->name('courses.publish');
        Route::post('/courses/{courseId}/unpublish', [AdminCourse::class, 'unpublish'])->name('courses.unpublish');
        Route::delete('/courses/{courseId}',  [AdminCourse::class, 'destroy'])->name('courses.destroy');
    });
});