<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRoles =auth()->user()->roles->pluck('name');

        if (in_array(['Admin', 'Staf'], $userRoles)) {
            return $next($request);
        } else {
            return redirect()->back();
        }

        // if ($userRoles == 2) {
        //     return redirect()->route('user.dashboard');
        // }
    }
}