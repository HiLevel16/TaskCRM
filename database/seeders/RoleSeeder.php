<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Content manager',
            'slug' => 'content_manager'
        ]);

        DB::table('roles')->insert([
            'name' => 'Link builder',
            'slug' => 'link_builder'
        ]);

        DB::table('roles')->insert([
            'name' => 'Accountant',
            'slug' => 'accountant'
        ]);

        DB::table('roles')->insert([
            'name' => 'Payer',
            'slug' => 'payer'
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

    }
}
