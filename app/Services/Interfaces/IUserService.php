<?php
    namespace App\Services\Interfaces;
    use App\Models\User;

    interface IUserService {
        public function createUser(array $data);
        public function getUserProfile(int $userId);
        public function updateAvatar(int $userId, string $avatarUrl);
        public function changePassword(int $userId, string $newPassword);
        public function updateProfile(User $user, array $data);
        public function enrollCourse(int $userId, int $courseId);
        public function completeLesson(int $userId, int $lessonId);
        public function getEnrolledCourse(int $userId);
        public function markLessonLearning(int $userId, int $lessonId);
        public function getLearningProgress(int $userId, int $lessonId);
        public function submitCourseReview(int $userId, int $courseId, string $reviewText);
        public function generateCertificate(int $userId, int $courseId);
        public function getQuizHistory(int $userId);
        public function calculateCompletionPercent(int $userId, int $courseId);
    }
?>