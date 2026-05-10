<?php
    namespace App\Http\Controllers;
    use App\Models\User;
use App\Services\Interfaces\IUserService;
use App\Services\UserService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;

    class UserController extends Controller{

        public function __construct(
            protected IUserService $userService
        ){}

        public function index() {
           $users = User::all();
           return view('pages.admin.index', compact('users'));
        }

        public function create() {
            return view('users.create');
        }

        public function register(Request $request){
            $validate = $request->validate([
                'fullname' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'role' => 'required|in:student,instructor',
                'terms' => 'required'
            ]);
            
            // create new user data
           User::create([
                'fullname' => $validate['fullname'],
                'email' => $validate['email'],
                'password_hash' => Hash::make($validate['password']),
                'role' => $validate['role'],
            ]);

            return redirect()->route('login')->with('success', 'create user successfully');
        }

        public function login(Request $request){
            // 1. Validate
            $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);


            // 2. Find User
            $user = User::where(
                'email',
                $credentials['email']
            )->first();

            // 3. Check User
            if(!$user){
                return back()->withErrors([
                    'email' => 'Email khong ton tai.'
                ]);
            }

            // 4. Verify Password
            if (!Hash::check(
                $credentials['password'],
                $user->password_hash
                )) {
                return back()->withErrors([
                    'password' => 'Sai mật khẩu'
                ]);
            }

            // 5. Save Session
            session(
            [
                'user_id' => $user->user_id,
                'fullname' => $user->fullname,
                'role' => $user->role
            ]);

            // 6. Redirect
            return redirect('/dashboard');
        }
    }
?>