<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(
        protected ICertificateService $certService
    ) {}

    /**
     * Danh sách chứng chỉ của học viên hiện tại.
     */
    public function index()
    {
        $certs = $this->certService->getByUser(session('user_id'));
        return view('pages.student.certificates', compact('certs'));
    }

    /**
     * Xem chi tiết / tải chứng chỉ.
     */
    public function show(string $certCode)
    {
        $cert = $this->certService->verify($certCode);

        if (!$cert) {
            abort(404, 'Chứng chỉ không tồn tại.');
        }

        $cert->load(['user', 'course']);

        return view('pages.certificate', compact('cert'));
    }

    /**
     * Trang verify công khai — ai cũng có thể check mã.
     */
    public function verify(Request $request)
    {
        $cert = null;

        if ($request->filled('code')) {
            $cert = $this->certService->verify($request->input('code'));
            $cert?->load(['user', 'course']);
        }

        return view('pages.certificate-verify', compact('cert'));
    }
}

?>