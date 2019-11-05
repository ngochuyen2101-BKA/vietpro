<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class checkLogin
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
        // cho phép thực hiện hành động tiếp theo muốn thực hiện
        if (Auth::check()) {
            return $next($request);
        }
        return redirect('login');
    }
}
