<?php


namespace App\Traits;


use App\Permission;

trait Permissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'roleId', 'permissionId');
    }
}