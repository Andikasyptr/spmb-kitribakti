<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user terautentikasi sebagai admin atau session admin hardcoded ada
        if ((Auth::check() && Auth::user()->role === 'admin') || 
            Session::has('admin_session')) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Please login as admin');
    }
}