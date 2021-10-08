<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Employer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // The user must be an employer 403 error
    if (Auth::guard('api')->check() && auth()->user()->role != '1') {
        $message = ["message" => "Permission Denied"];
        return response($message, 403);
    } else {
        return $next($request);
    }
    }
}
