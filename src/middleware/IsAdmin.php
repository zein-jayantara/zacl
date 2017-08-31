<?php

namespace Zein\Zacl\Middleware;

use Closure;
use Zein\Zacl\Lib;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->user()->isadmin) {
            return Lib::sendError("Bukan Administrator");
        }
        
        return $next($request);
    }
}
