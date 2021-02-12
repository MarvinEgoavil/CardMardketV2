<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckParticular
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::debug("Usuario " . Auth::User()->role);
        if (Auth::User()->role != 'admin')
            return $next($request);

        return response()->json([
            'message' => 'Usuario no autorizado'
        ], 403);
    }
}
