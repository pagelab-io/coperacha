<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Entities\User::class, function (Faker\Generator $faker) {

    return [
        'person_id' => 0,
        'username' => $faker->name,
        'email' => $faker->name . '@gmail.com',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10)
    ];
});


$factory->define(\App\Entities\Person::class, function (Faker\Generator $faker) {

    $gender = $faker->randomDigit % 2 == 0 ? 'male' : 'female';

    return [
        'name'     => $faker->firstName($gender),
        'lastname' => $faker->lastName,
        'phone'    => $faker->phoneNumber,
        'gender'   => $faker->randomDigit % 2 == 0 ? 'H' : 'M',
        'birthday' => $faker->date($format = 'Y-m-d', $max = '2000-06-09'),
        'city'     => $faker->city(),
        'country'  => $faker->country()
    ];
});
