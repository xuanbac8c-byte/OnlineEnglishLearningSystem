<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    public function index()
    {
        return view('pages.blog');
    }

    public function show(string $slug)
    {
        
        abort(404);
    }
}

?>