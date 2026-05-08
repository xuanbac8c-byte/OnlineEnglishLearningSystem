<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/', function (){
        return view('pages/home');
    });
?>
