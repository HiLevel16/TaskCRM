<?php

namespace App\Http\Middleware;

use App\Project;
use Closure;

class CheckProjectMember
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $userId
     * @param $projectId
     * @return mixed
     */
    public function handle($request, Closure $next, $userId, $projectId)
    {
        if (!Project::isUserAMember($userId, $projectId))
            return redirect('/tasks');


        return $next($request);
    }
}
