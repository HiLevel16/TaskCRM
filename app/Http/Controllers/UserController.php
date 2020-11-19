<?php

namespace App\Http\Controllers;

use App\Project;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hasPermission:create_user')->only(['pageAdd', 'addUser']);
        $this->middleware('hasPermission:edit_user')->only(['pageEdit', 'editUser']);
        $this->middleware('hasPermission:delete_user')->only(['delete']);
    }

    public function index()
    {
         $users = User::where('id', '!=', Auth::user()->id)->paginate(15);

         return view('users.users', [
             'users' => $users
         ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $user = User::find($request->id);
        if ($user) {
            $user->deleteUser();
        }

        return Redirect::back()->with('success', 'User was successfully deleted');
    }

    public function pageAdd()
    {
        $projects = Project::all();
        $roles = Role::get();

        return view('users.add_user', [
            'projects' => $projects,
            'roles' => $roles
        ]);
    }

    public function pageEdit(Request $request)
    {
        $projects = Project::all();
        $roles = Role::get();
        $user = User::find($request->id);
        $userProjects = $user->getProjects();


        return view('users.edit_user', [
            'projects' => $projects,
            'roles' => $roles,
            'user' => $user,
            'userProjects' => $userProjects
        ]);
    }

    public function addUser(Request $request)
    {
        return $this->store($request);
    }

    public function editUser(Request $request)
    {
        return $this->store($request);
    }

    private function store(Request $request)
    {
        $validator = User::validateRequest($request);

        if (!empty($ret = $this->processValidate($request, $validator))) {
            return $ret;
        }

        User::store($request);
        $message = isset($request->id) ? 'The user was successfully updated' : 'The user was successfully created';
        return Redirect::back()->with('success', $message);
    }

    private function processValidate(Request $request, $validator)
    {
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
    }

}
