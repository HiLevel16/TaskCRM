<?php

namespace App\Http\Middleware;

use App\Project;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HasProjects
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
        if (!Auth::user()->has('projects', '>', 0)) {
            return Redirect::back()->withErrors('You don\'t have projects to add tasks in');
        }
        return $next($request);
    }
}
