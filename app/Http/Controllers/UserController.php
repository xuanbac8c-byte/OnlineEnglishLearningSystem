<?php
    namespace App\Http\Controllers;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    class UserController extends Controller{
        public function index() {
           $users = User::all();
           return view('users.index', compact('users'));
        }

        public function create() {
            return view('users.create');
        }

        public function store(Request $request){
            User::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect('/users');
        }
    }
?>