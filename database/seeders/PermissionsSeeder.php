<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    //  ids:
    //  1 - content manager
    //  2 - link builder
    //  3 - Accountant
    //  4 - Payer
    //  5 - Admin
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = [
            //Users
            'View users' => 'view_user',
            'Create users' => 'create_user',
            'Edit users' => 'edit_user',
            'Delete users' => 'delete_user',
            //Tasks
            'View own tasks' => 'view_own_task',
            'View all tasks' => 'view_all_task',
            'Create tasks' => 'create_task',
            'Edit own tasks' => 'edit_own_task', //Edit only tasks created by themselves
            'Edit all tasks' => 'edit_all_task',
            'Send tasks to another user' => 'send_task',
            'Delete own tasks' => 'delete_own_task',
            'Delete all tasks' => 'delete_all_task',
            //Projects
            'View projects' => 'view_project',
            'Create projects' => 'create_project',
            'Edit projects' => 'edit_project',
            'Delete projects' => 'delete_project',
            //Roles
            'View roles' => 'view_role',
            'Create roles' => 'create_role',
            'Edit roles' => 'edit_role',
            'Delete roles' => 'delete_role',
            //Category
            'View categories' => 'view_category',
            'Create categories' => 'create_category',
            'Edit category' => 'edit_category',
            'Delete category' => 'delete_category'
        ];

        //Content manager permissions:
        $contentManagerPermissions = [
            'View own tasks' => 'view_own_task',
            'Create tasks' => 'create_task',
            'Edit own tasks' => 'edit_own_task',
            'Delete own tasks' => 'delete_own_task'
        ];

        //Link builder permissions:
        $linkBuilderPermissions = [
            'View own tasks' => 'view_own_task',
            'Create tasks' => 'create_task',
            'Edit own tasks' => 'edit_own_task',
            'Delete own tasks' => 'delete_own_task'
        ];

        //Accountant permissions:
        $accountantPermissions = [
            'View all tasks' => 'view_all_task',
            'Edit all tasks' => 'edit_all_task',
            'Delete all tasks' => 'delete_all_task',
            'Create tasks' => 'create_task',
            'Send tasks to another user' => 'send_task',
        ];

        //Payer permissions
        $payerPermissions = [
            'View own tasks' => 'view_own_task',
            'Edit own tasks' => 'edit_own_task'
        ];

        $tmp = [];

        foreach ($contentManagerPermissions as $label => $slug)
        {
            $id = null;
            if (!isset($tmp[$slug])) {
                $id = DB::table('permissions')->insertGetId([
                    'label' => $label,
                    'slug' => $slug
                ]);
                $tmp[$slug] = $id;
            } else {
                $id = $tmp[$slug];
            }
            DB::table('permission_role')->insert([
                'permissionId' => $id,
                'roleId' => 1
            ]);
        }

        foreach ($linkBuilderPermissions as $label => $slug)
        {
            $id = null;
            if (!isset($tmp[$slug])) {
                $id = DB::table('permissions')->insertGetId([
                    'label' => $label,
                    'slug' => $slug
                ]);
                $tmp[$slug] = $id;
            } else {
                $id = $tmp[$slug];
            }
            DB::table('permission_role')->insert([
                'permissionId' => $id,
                'roleId' => 2
            ]);
        }

        foreach ($accountantPermissions as $label => $slug)
        {
            $id = null;
            if (!isset($tmp[$slug])) {
                $id = DB::table('permissions')->insertGetId([
                    'label' => $label,
                    'slug' => $slug
                ]);
                $tmp[$slug] = $id;
            } else {
                $id = $tmp[$slug];
            }
            DB::table('permission_role')->insert([
                'permissionId' => $id,
                'roleId' => 3
            ]);
        }

        foreach ($payerPermissions as $label => $slug)
        {
            $id = null;
            if (!isset($tmp[$slug])) {
                $id = DB::table('permissions')->insertGetId([
                    'label' => $label,
                    'slug' => $slug
                ]);
                $tmp[$slug] = $id;
            } else {
                $id = $tmp[$slug];
            }
            DB::table('permission_role')->insert([
                'permissionId' => $id,
                'roleId' => 4
            ]);
        }

        foreach ($allPermissions as $label => $slug)
        {
            $id = null;
            if (!isset($tmp[$slug])) {
                $id = DB::table('permissions')->insertGetId([
                    'label' => $label,
                    'slug' => $slug
                ]);
                $tmp[$slug] = $id;
            } else {
                $id = $tmp[$slug];
            }
            DB::table('permission_role')->insert([
                'permissionId' => $id,
                'roleId' => 5
            ]);
        }
    }
}
