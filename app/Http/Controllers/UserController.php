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
}
?>