<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (is_null(auth()->user())) {
            return redirect('/');
        }
        if (auth()->user()->hasRole(['root', 'admin'])) {
            return $next($request);
        }
        return redirect('/');
    }
}
