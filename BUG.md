=== STATIC CODE ANALYSIS - BUG FINDER ===

Checking all source files for issues...
=== 1. NAMESPACE BUG in QuizManagerController ===
2:use IQuizOptionService;
3:use IQuizService;

=== 2. WRONG KEY in UserFactory ===
// database/factories/UserFactory.php line 25:
'name' => 'fullname',  // BUG: should be 'fullname' => fake()->name()
// Same issue in DatabaseSeeder.php line 20:
'name' => 'fullname', // BUG: wrong key

=== 3. MISSING ROUTE for student.lesson.show ===
// resources/views/pages/lesson.blade.php references:
// route('student.lesson.show', [$courseId, $sLesson->lesson_id])
// But in routes/web.php the route is:
// Route::get('/courses/{courseId}/lessons/{lessonId}', ...)->name('lesson.show');
// Missing 'student.' prefix in view — route() call would work but
// view also loads lesson->section->course->sections which causes N+1 query

=== 4. NAVBAR does not show user info when logged in ===
// resources/views/components/navbar.blade.php:
// Always shows Login/Register buttons regardless of session state.
// Should check session('user_id') and conditionally render user menu.

=== 5. MISSING view file: pages.student.checkout ===
// Student/PaymentController@checkout returns view('pages.student.checkout')
// But the actual view file is at: resources/views/pages/checkout.blade.php
// Path mismatch: 'pages.student.checkout' vs 'pages.checkout'

=== 6. MISSING view: pages.admin.courses (duplicate routes) ===
// Admin/DashboardController@courses and Admin/CourseController@index
// both return view('pages.admin.courses')
// But Admin/CourseController returns view('pages.admin.course-manager') 
// while the actual file is: resources/views/pages/admin/course-manager.blade.php
// The route admin.courses maps to BOTH controllers — Admin/CourseController takes priority

=== 7. MISSING view: pages.student.lesson ===
// Student/LessonController@show returns view('pages.student.lesson')
// But the actual file is at: resources/views/pages/lesson.blade.php
// Path mismatch will cause ViewNotFoundException at runtime

=== 8. ENROLLMENT unique constraint vs timestamps ===
// Migration: $table->unique(['user_id', 'course_id'])
// But Enrollment model has 'enrolled_at' cast to datetime AND timestamps = true
// enrolled_at is set manually AND via useCurrent() — potential redundancy

=== 9. SectionService::reorder — no authorization check ===
// CourseManagerController::reorderSections calls sectionService->reorder()
// No check that the course belongs to the requesting instructor
// An instructor could reorder sections of another instructor's course
// Same issue with reorderLessons()

=== 10. QUIZ ANSWER: multiple_choice not handled in saveBulk ===
// Student/QuizController@submit validates:
//   'answers.*.selected_option_id' => 'nullable|integer'
// But for multiple_choice questions, student selects MULTIPLE options.
// The form sends selected_option_id[] array but the service only saves one answer.
// IQuizAnswerService::saveAnswer() stores a single selected_option_id.
// Multiple choice answers would silently lose data.