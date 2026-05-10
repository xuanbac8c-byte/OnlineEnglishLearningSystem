<?php

namespace App\Providers;

use App\Services\CertificateService;
use App\Services\CourseReviewService;
use App\Services\CourseService;
use App\Services\EnrollmentService;
use App\Services\Interfaces\ILanguageService;
use App\Services\Interfaces\IUserService;
use App\Services\LanguageService;
use App\Services\LessonProgressService;
use App\Services\LessonService;
use App\Services\PaymentService;
use App\Services\QuizAnswerService;
use App\Services\QuizAttemptService;
use App\Services\QuizOptionService;
use App\Services\QuizService;
use App\Services\SectionService;
use App\Services\UserService;
use ICertificateService;
use ICourseReviewService;
use ICourseService;
use IEnrollmentService;
use ILessonProgressService;
use ILessonService;
use Illuminate\Support\ServiceProvider;
use IPaymentService;
use IQuizAnswerService;
use IQuizAttemptService;
use IQuizOptionService;
use IQuizService;
use ISectionService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IUserService::class,            UserService::class);
        $this->app->bind(ILanguageService::class,        LanguageService::class);
        $this->app->bind(ILessonService::class,          LessonService::class);
        $this->app->bind(ILessonProgressService::class,  LessonProgressService::class);
        $this->app->bind(ISectionService::class,         SectionService::class);
        $this->app->bind(ICourseService::class,          CourseService::class);
        $this->app->bind(ICourseReviewService::class,    CourseReviewService::class);
        $this->app->bind(IEnrollmentService::class,      EnrollmentService::class);
        $this->app->bind(IPaymentService::class,         PaymentService::class);
        $this->app->bind(ICertificateService::class,     CertificateService::class);
        $this->app->bind(IQuizService::class,            QuizService::class);
        $this->app->bind(IQuizOptionService::class,      QuizOptionService::class);
        $this->app->bind(IQuizAnswerService::class,      QuizAnswerService::class);
        $this->app->bind(IQuizAttemptService::class,     QuizAttemptService::class);
    }

    public function boot(): void {}
}