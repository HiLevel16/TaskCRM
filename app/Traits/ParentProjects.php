<?php


namespace App\Traits;


use App\Project;

trait ParentProjects
{

    public function parentProjects()
    {
        return $this->belongsTo(Project::class, 'parent');
    }
}