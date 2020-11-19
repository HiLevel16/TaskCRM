<?php

namespace App;

use App\Traits\Permissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Role extends Model
{
    use Permissions;

    public static function validateRequest($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required'
        ]);
    }

    public static function store($request)
    {
        $role = null;

        if (isset($request->id)) {
            $role = Role::find($request->id);
        } else {
            $role = new Role;
        }

        $role->name = $request->name;
        $role->slug = $request->slug;

        $permissions = [];
        DB::beginTransaction();
        $role->save();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $permissions[] = Permission::find($permission);
            }
            $role->permissions()->saveMany($permissions);
        }
        DB::commit();
    }

    public function hasPermission($slug)
    {
        return $this->permissions->contains('slug', $slug);
    }

}
