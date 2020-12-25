<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class checkGender
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
        $user = Auth::user();
        if(!$user->gender == '' || !$user->gender == null){ // if user has gender
            return $next($request);
        }
        return redirect()->route('fillGender',[$user]); // user hasn't fill a gender.
    }
}
