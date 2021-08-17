<?php

namespace AV_Core\Http\Middleware;

use Closure;
use Auth;

class AclMiddleware
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
        if (Auth::check()) {
            return $next($request);
        }

        return abort('404');
        // return redirect()->route('home');
    }
}
