<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IEnrollmentService;
use App\Services\Interfaces\IPaymentService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct(
        protected IEnrollmentService $enrollmentService,
        protected IPaymentService $paymentService,
    ) {}

    /**
     * Đăng ký khóa học miễn phí (price = 0).
     */
    public function enroll(int $courseId)
    {
        $userId = session('user_id');

        if ($this->enrollmentService->isEnrolled($userId, $courseId)) {
            return back()->with('info', 'Bạn đã đăng ký khóa học này rồi.');
        }

        $this->enrollmentService->enroll($userId, $courseId);

        return redirect()->route('student.dashboard')
            ->with('success', 'Đăng ký khóa học thành công!');
    }

    /**
     * Huỷ đăng ký.
     */
    public function unenroll(int $courseId)
    {
        $this->enrollmentService->unenroll(session('user_id'), $courseId);

        return back()->with('success', 'Đã huỷ đăng ký khóa học.');
    }

    /**
     * Kiểm tra sau thanh toán → tự động enroll.
     */
    public function afterPayment(Request $request)
    {
        $ref = $request->query('ref');

        $payment = $this->paymentService->findByRef($ref);

        if (!$payment || $payment->status !== 'paid') {
            return redirect()->route('courses.index')
                ->withErrors('Thanh toán không hợp lệ hoặc chưa được xác nhận.');
        }

        $userId   = $payment->user_id;
        $courseId = $payment->course_id;

        if (!$this->enrollmentService->isEnrolled($userId, $courseId)) {
            $this->enrollmentService->enroll($userId, $courseId);
        }

        return redirect()->route('student.dashboard')
            ->with('success', 'Thanh toán thành công! Bạn đã được đăng ký khóa học.');
    }
}

?>