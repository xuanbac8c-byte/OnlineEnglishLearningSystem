<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Services\Interfaces\IUserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService implements IUserService
{
    public function createUser(array $data): User
    {
        return User::create([
            'fullname'      => $data['fullname'],
            'email'         => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'role'          => $data['role'],
        ]);
    }

    public function getUserProfile(int $userId): ?User
    {
        return User::find($userId);
    }

    public function updateAvatar(int $userId, string $avatarUrl): bool
    {
        return (bool) User::where('user_id', $userId)->update(['avatar_url' => $avatarUrl]);
    }

    public function changePassword(int $userId, string $newPassword): bool
    {
        return (bool) User::where('user_id', $userId)->update([
            'password_hash' => Hash::make($newPassword),
        ]);
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->update([
            'fullname' => $data['fullname'],
            'email'    => $data['email'],
        ]);

        return $user;
    }

    public function enrollCourse(int $userId, int $courseId): Enrollment
    {
        return Enrollment::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $courseId],
            ['enrolled_at' => now()]
        );
    }

    public function completeLesson(int $userId, int $lessonId): LessonProgress
    {
        return LessonProgress::updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $lessonId],
            ['completed_percent' => 100, 'is_completed' => true, 'completed_at' => now()]
        );
    }

    // Dùng Eloquent thay raw query sai tên bảng
    public function getEnrolledCourse(int $userId)
    {
        return Enrollment::where('user_id', $userId)->with('course')->get()->pluck('course');
    }

    public function markLessonLearning(int $userId, int $lessonId): LessonProgress
    {
        return LessonProgress::updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $lessonId],
            ['is_completed' => false]
        );
    }

    public function getLearningProgress(int $userId, int $lessonId): ?LessonProgress
    {
        return LessonProgress::where('user_id', $userId)->where('lesson_id', $lessonId)->first();
    }

    public function submitCourseReview(int $userId, int $courseId, string $reviewText): CourseReview
    {
        return CourseReview::create([
            'user_id'   => $userId,
            'course_id' => $courseId,
            'comment'   => $reviewText,
            'rating'    => 5,
        ]);
    }

    public function generateCertificate(int $userId, int $courseId): Certificate
    {
        return Certificate::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $courseId],
            ['cert_code' => 'CERT-' . strtoupper(Str::random(10)), 'issued_at' => now()]
        );
    }

    public function getQuizHistory(int $userId)
    {
        return QuizAttempt::where('user_id', $userId)->get();
    }

    // Dùng Eloquent thay raw query sai tên bảng
    public function calculateCompletionPercent(int $userId, int $courseId): float
    {
        $totalLessons = \App\Models\Lesson::whereHas('section', fn($q) => $q->where('course_id', $courseId))->count();

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = LessonProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->whereHas('lesson.section', fn($q) => $q->where('course_id', $courseId))
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }
}

?>