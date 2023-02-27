<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->session()->get('user');
        if($user->role == "Admin") {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
