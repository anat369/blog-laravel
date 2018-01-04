<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
// если пользователь залогинен и он админ, то допускаем его в админ-панель
        if(Auth::check() && Auth::user()->is_admin)
        {
            return $next($request);
        }
// иначе выдаем страницу 404
        abort(404);
    }
}
