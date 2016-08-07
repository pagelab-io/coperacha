<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        factory(\App\Entities\Category::class, 5)->create();
        Model::reguard();
    }
}
