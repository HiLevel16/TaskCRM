<?php

namespace App\Http\Controllers;

use App\Project;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
         $users = User::where('id', '!=', Auth::user()->id)->get();

         return view('users', [
             'users' => $users
         ]);
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

    public function pageEdit()
    {
        $projects = Project::all();
        $roles = Role::get();

        return view('users.add_user', [
            'projects' => $projects,
            'roles' => $roles
        ]);
    }

    public function storeUser(Request $request)
    {
        if (empty( $request->except('_token')))
            return Redirect::back()->withErrors('Request is empty');

        $validator = User::validateRequest($request);

        if (!empty($ret = $this->proccessValidateUser($request, $validator))) {
            return $ret;
        }

        User::store($request);
        $message = isset($request->id) ? 'The user was successfully updated' : 'The user was successfully created';
        return Redirect::back()->with('success', $message);
    }

    private function proccessValidateUser(Request $request, $validator)
    {
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->with('name', $request->name)
                ->with('description', $request->description)
                ->with('projects', $request->projects);
        }
    }

}
