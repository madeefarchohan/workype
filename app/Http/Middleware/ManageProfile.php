<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ManageProfile
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
        $user_param = $request->route('user');
        $user = Auth::user();
        if(Auth::user()->hasRole('admin')){

            return $next($request);
        }
        else if ( Auth::check()  && $user->id == $user_param)
        {
            return $next($request);
        }

        return redirect('/');
    }
}
