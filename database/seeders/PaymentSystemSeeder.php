<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_systems')->insert([
            'name' => 'BTC'
        ]);
        DB::table('payment_systems')->insert([
            'name' => 'PayPal'
        ]);
        DB::table('payment_systems')->insert([
            'name' => 'WebMoney'
        ]);
        DB::table('payment_systems')->insert([
            'name' => 'QIWI'
        ]);
        DB::table('payment_systems')->insert([
            'name' => 'Bank account'
        ]);
    }
}
