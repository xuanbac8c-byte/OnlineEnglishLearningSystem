<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Interfaces\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected IUserService $userService
    ) {}

    // Dùng cho admin: danh sách users
    public function index()
    {
        $users = User::latest()->paginate(20);

        return view('pages.admin.users', compact('users'));
    }

    // Register vẫn giữ lại ở đây để dùng với route /register (nếu cần)
    // Nhưng nên dùng Auth/RegisterController::register() thay thế
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:student,instructor',
            'terms'    => 'required',
        ]);

        $this->userService->createUser($validated);

        return redirect()->route('login')->with('success', 'Tạo tài khoản thành công!');
    }
}
?>