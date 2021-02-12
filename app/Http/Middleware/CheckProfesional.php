<?php

namespace App\Http\Middleware;

use Closure;

class CheckProfesional
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
        if (auth()->user()->role != 'profe')
            return response()->json([
                'message' => 'Usuario no autorizado'
            ], 403);

        return $next($request);
    }
}
