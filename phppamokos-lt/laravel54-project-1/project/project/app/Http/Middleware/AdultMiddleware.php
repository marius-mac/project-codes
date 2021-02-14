<?php

namespace App\Http\Middleware;

use Closure;

class AdultMiddleware
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
        if (Session::get('age') < 18) {
            return redirect('/home');
        }

        return $next($request);
    }
}
