<?php 
    namespace App\Services;

use App\Models\Certificate;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Models\User;
    use App\Services\Interfaces;
    use App\Services\Interfaces\IUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

    class UserService implements IUserService{
        public function createUser($data) {
            return User::create([
                'fullname' => $data['fullname'],
                'email' => $data['email'],
                'password_hash' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);
        }

        public function getUserProfile(int $userId) {
            return User::find($userId);
        }

        public function updateAvatar(int $userId, string $avatarUrl) {
            return User::where(
                'user_id', $userId
            )->update(
                ['avatar_url' => $avatarUrl]
            );
        }

        public function changePassword(int $userId,string $newPassword) {
            return User::where(
                'user_id', $userId
            )->update([
                'password_hash' => Hash::make($newPassword)
            ]);
        }

        public function updateProfile(User $user,array $data) {
            $user->update([
                'fullname' => $data['fullname'],
                'email' => $data['email']
            ]);
            return $user;
        }

        public function enrollCourse(int $userId, int $courseId) {
            return Enrollment::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrolled_at' => now()
            ]);
        }

        public function completeLesson(int $userId, int $lessonId) {
            return LessonProgress::updateOrCreate(
                [
                    'user_id' => $userId,
                    'lesson_id' => $lessonId
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now()
                ]
            );
        }

        public function getEnrolledCourse(int $userId) {
            return DB::table('enrollment')
                ->join(
                    'course',
                    'enrollment.course_id',
                    '=',
                    'course.id'
                )
                ->where('enrollment.user_id', $userId)
                ->select('course.*')
                ->get();
        }

        public function markLessonLearning(int $userId,int $lessonId) {

            return LessonProgress::updateOrCreate(
                [
                    'user_id' => $userId,
                    'lesson_id' => $lessonId
                ],
                [
                    'is_completed' => false
                ]
            );
        }

        public function getLearningProgress(int $userId,int $lessonId) {
            return LessonProgress::where(
                'user_id',
                $userId
            )
            ->where(
                'lesson_id',
                $lessonId
            )
            ->first();
        }

        public function submitCourseReview(int $userId,int $courseId,string $reviewText) {
            return CourseReview::create(
                [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'comment' => $reviewText,
                    'rating' => 5
                ]
            );
        }

        public function generateCertificate(int $userId,int $courseId) {
            return Certificate::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'cert_code' => uniqid('CERT-'),
                'issued_at' => now()
            ]);
        }

        public function getQuizHistory(int $userId) {
            return QuizAttempt::where(
                'user_id',
                $userId
            )->get();
        }

        public function calculateCompletionPercent(int $userId,int $courseId) {
            $totalLessons = DB::table('lesson')
                ->join(
                    'section',
                    'lesson.section_id',
                    '=',
                    'section.id'
                )
                ->where(
                    'section.course_id',
                    $courseId
                )
                ->count();

            $completedLessons = DB::table('lesson_progresses')
                ->join(
                    'lesson',
                    'lesson_progresses.lesson_id',
                    '=',
                    'lesson_id'
                )
                ->join(
                    'section',
                    'lesson.section_id',
                    '=',
                    'section.id'
                )
                ->where(
                    'lesson_progresses.user_id',
                    $userId
                )
                ->where(
                    'lesson_progresses.is_completed',
                    true
                )
                ->where(
                    'section.course_id',
                    $courseId
                )
                ->count();

            if($totalLessons == 0){
                return 0;
            }

            return round(
                ($completedLessons / $totalLessons) * 100,
                2
            );
        }
    }
?>