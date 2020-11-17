<?php


namespace App\Traits;


use App\Project;
use App\Role;

trait HasRolesAndProjects
{
    /**
     * User's projects
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'userId', 'projectId');
    }

    /**
     * User's roles
     */
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');
    }
}