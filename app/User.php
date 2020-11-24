<?php

namespace App;

use App\Enums\TaskStatus;
use App\Traits\HasRolesAndProjects;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class User
 * @package App
 */
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

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->roles->contains('slug', $role))
            return true;

        return false;
    }

    /**
     * @param $projectId
     * @return mixed
     */
    public function hasProject($projectId)
    {
        return $this->projects->contains('id', $projectId);
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        if ($this->hasPermission('view_project')) {
            return new Project;
        } else {
            return $this->projects();
        }
    }

    /**
     * @param $permission
     * @return mixed
     */
    public function hasPermission($permission)
    {
        return $this->linkedRole->permissions->contains('slug', $permission);
    }

    /**
     * @param string $status
     * @return mixed
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email:rfc'
        ]);
    }

    /**
     * @param Request $request
     */
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

    /**
     * @throws \Exception
     */
    public function deleteUser()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('task_show_user')->where('userId', $this->id)->delete();
        $this->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Returns array of filters to display
     * @return array
     */
    public function generateTaskFilterArray($input)
    {


        $filterArray = $this->getTaskFilterShowArray();
        $filterArray = $this->fillTaskFilterArray($filterArray, $input);



        return $filterArray;
    }

    private function getTaskFilterShowArray()
    {
        //Generate what to show and what not to show
        $filterArray = [
            'projects' => ['show' => false],
            'users' => ['show' => false],
            'categories' => ['show' => true],
            'paymentSystems' => ['show' => true],
            'statuses' => ['show' => true],
            'date' => ['show' => true]
        ];
        if ($this->hasPermission('view_all_task')) { //if user can view everything
            $filterArray['projects']['show'] = true;
            $filterArray['users']['show'] = true;
            return $filterArray;
        }

        if ($this->projects()->count() > 1)
            $filterArray['projects'] = true;

        return $filterArray;
    }

    private function fillTaskFilterArray($array, $input)
    {
        $array = $this->fillTaskFilterWithProjects($array, $input);
        $array = $this->fillTaskFilterWithUsers($array, $input);
        $array = $this->fillTaskFilterWithCategories($array, $input);
        $array = $this->fillTaskFilterWithPaymentSystems($array, $input);
        $array = $this->fillTaskFilterWithStatuses($array, $input);
        return $array;
    }

    private function fillTaskFilterWithProjects($array, $input)
    {
        $parentProjects = $this->getProjects()->where('parent', null)->get();

        if ($parentProjects->count()) {
            foreach ($parentProjects as $project) {
                $array['projects']['items'][$project->id] = ['label' => $project->name, 'id' => $project->id];
            }
        }

        $childProjects = $this->getProjects()->whereNotNull('parent')->get();

        foreach ($childProjects as $project) {
            if (isset($array['projects']['items'][$project->parent])) {
                $array['projects']['items'][$project->parent]['child'][] = ['label' => $project->name, 'id' => $project->id];
            } else {
                $array['projects']['items'][$project->id] = ['label' => $project->name, 'id' => $project->id];
            }
        }
        return $array;
    }

    private function fillTaskFilterWithUsers($array, $input)
    {
        $users = User::get();

        foreach ($users as $user) {
            $array['users']['items'][] = ['label' => $user->name, 'id' => $user->id];
        }

        return $array;
    }

    private function fillTaskFilterWithCategories($array, $input)
    {
        $categories = TaskCategory::get();

        foreach ($categories as $category) {
            $array['categories']['items'][] = ['label' => $category->name, 'id' => $category->id];
        }


        return $array;
    }

    private function fillTaskFilterWithPaymentSystems($array, $input)
    {
        $paymentSystems = PaymentSystem::get();

        foreach ($paymentSystems as $paymentSystem) {
            $array['paymentSystems']['items'][] = ['label' => $paymentSystem->name, 'id' => $paymentSystem->id];
        }

        return $array;
    }

    private function fillTaskFilterWithStatuses($array, $input)
    {
        $statuses = TaskStatus::asArray();

        foreach ($statuses as $key => $status) {
            $array['statuses']['items'][] = ['label' => $status];
        }

        return $array;
    }


}
