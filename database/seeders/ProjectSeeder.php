<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name' => 'Sportlights',
            'icon' => '',
            'parent' => NULL
        ]);

        DB::table('project_user')->insert([
            'userId' => 1,
            'projectId' => 1
        ]);
    }
}
