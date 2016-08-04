<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //$this->call(UsersTableSeeder::class);
        //factory(\App\Entities\User::class, 500)->create();
        factory(\App\Entities\Person::class, 100)->create()->each(function ($person) {
            $user = $person->user()->save(factory(\App\Entities\User::class)->make());
            $user->username = strtolower($person->name);
            $user->email = strtolower($person->name . '@gmail.com');
            $user->save();
        });

        Model::reguard();
    }
}
