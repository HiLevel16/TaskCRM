<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_category')->insert([
            'name' => 'LinkBuilding'
        ]);
        DB::table('task_category')->insert([
            'name' => 'SEO'
        ]);
        DB::table('task_category')->insert([
            'name' => 'Salary'
        ]);

    }
}
