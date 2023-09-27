<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::user()->user_type == 'superadmin'){
                    return redirect('admin');
                }

                if(Auth::user()->user_type == 'admin'){
                    return redirect('admin');
                }

                if(Auth::user()->user_type == 'staff'){
                    return redirect('admin');
                }

                if(Auth::user()->user_type == 'guest'){
                    return redirect('guest');
                }
                
            }
        }

        return $next($request);
    }
}
