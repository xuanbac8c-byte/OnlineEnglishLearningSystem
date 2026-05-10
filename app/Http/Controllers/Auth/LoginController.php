<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại.'])->withInput();
        }

        if (!Hash::check($credentials['password'], $user->password_hash)) {
            return back()->withErrors(['password' => 'Mật khẩu không đúng.'])->withInput();
        }

        session([
            'user_id'  => $user->user_id,
            'fullname' => $user->fullname,
            'role'     => $user->role->value,
        ]);

        return match ($user->role->value) {
            'admin'      => redirect()->route('admin.dashboard'),
            'instructor' => redirect()->route('instructor.dashboard'),
            default      => redirect()->route('student.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công.');
    }
}

?>