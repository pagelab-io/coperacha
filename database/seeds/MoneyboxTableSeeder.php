<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class MoneyboxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        factory(\App\Entities\Moneybox::class, 10)->create();
        Model::reguard();
    }
}
