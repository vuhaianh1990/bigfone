<?php

namespace AV_Core\Http\Middleware;

use Closure;
use Auth;
use AV_Core\Models\User;

class CheckSuperAdmin
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
        if (User::isAdmin() === TRUE) {
            return $next($request);
        }
        return redirect('/admincp');
    }
}
