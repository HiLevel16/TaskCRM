<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hasPermission:view_role')->only(['index']);
        $this->middleware('hasPermission:edit_role')->only(['pageEdit', 'edit']);
        $this->middleware('hasPermission:create_role')->only(['pageAdd', 'add']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $roles = Role::paginate(15);
        return view('roles.roles', [
            'roles' => $roles
        ]);
    }

    /**
     * @param Request $request
     */
    public function pageEdit(Request $request)
    {
        $role = Role::find($request->id);
        $permissions = Permission::get();
        return view('roles.edit_role', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     *
     */
    public function pageAdd()
    {
        $allPermissions = Permission::get();
        return view('roles.add_role', [
            'allPermissions' => $allPermissions
        ]);
    }

    /**
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $this->store($request);
    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        return $this->store($request);
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $users = User::where('role', $request->id);
        if ($users->count() > 0) {
            return Redirect::back()->withErrors('Could\'nt delete role because some users have it');
        }
        $role = Role::find($request->id);
        if ($role) {
            $role->deleteRole();
        }
        return Redirect::back()->with('success', 'Role was successfully deleted');
    }

    /**
     * @param Request $request
     */
    private function store(Request $request)
    {
        $validator = Role::validateRequest($request);

        if (!empty($ret = $this->processValidate($request, $validator))) {
            return $ret;
        }

        Role::store($request);
        $message = isset($request->id) ? 'The role was successfully updated' : 'The role was successfully created';
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
