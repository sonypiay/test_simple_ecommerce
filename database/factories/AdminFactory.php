<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Model\Users;
use Faker\Generator as Faker;

$factory->define(Users::class, function (Faker $faker) {
    $fullname = $faker->name();
    $email    = $faker->safeEmail();
    $password = Hash::make( '12345678' );

    return [
      'id'          => Str::uuid()->toString(),
      'nama'        => $fullname,
      'email'       => $email,
      'password'    => $password,
      'roles'       => 'admin',
      'created_at'  => now(),
      'updated_at'  => now(),
    ];
});
