<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user_id')) {
            return redirect()->route(match (session('role')) {
                'admin'      => 'admin.dashboard',
                'instructor' => 'instructor.dashboard',
                default      => 'student.dashboard',
            });
        }

        return $next($request);
    }
}

?>