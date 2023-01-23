<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request):redirect('/login'); (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->path() == 'app/admin_login') {
            return $next($request);
        }

        Log::info("AdminCheck middleware");
        if (!Auth::check()) {
            //log info return redirect('/login');
            return response()->json([
                'msg' => "You are not allowed to access this route....."
            ], 403);
        }

        $user = Auth::user();
        if ($user->userType == "User") {
            return response()->json([
                'msg' => "You are not allowed to access this route....."
            ], 403);
        }
        return $next($request);
    }
}