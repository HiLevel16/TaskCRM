<?php

namespace App;

use App\Traits\HasRolesAndProjects;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndProjects;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasRole($role)
    {
        if ($this->roles->contains('slug', $role))
            return true;

        return false;
    }

    public function hasProject($projectId)
    {
        if ($this->projects->contains('id', $projectId))
            return true;

        return false;
    }

    public function getProjects()
    {
        return $this->projects();
    }

    public function hasPermission($permission)
    {
        return $this->linkedRole->permissions->contains('slug', $permission);
    }

    public function getTasks($status = 'all')
    {
        if ($status == 'all') {
            if (!$this->hasPermission('view_all_task')) {
                return Task::where('fromId', $this->id)->orderBy('created_at', 'asc');
            } else {
                return Task::orderBy('created_at', 'asc');
            }
        } else {

        }
    }

    public static function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email:rfc'
        ]);
    }

    public static function store(Request $request)
    {
        $user = null;

        if (isset($request->id)) {
            $user = User::find($request->id);
        } else {
            $user = new User;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;

        $projects = [];

        DB::beginTransaction();

        $user->save();
        if ($request->projects) {
            foreach ($request->projects as $project) {
                $projects[] = Project::find($project);
            }
            $user->projects()->saveMany($projects);
        }


        DB::commit();

    }



}
