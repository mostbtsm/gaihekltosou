<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Painter;
use Faker\Generator as Faker;

$factory->define(Painter::class, function (Faker $faker) {
    $num = $faker->unique()->numberBetween(1000, 9999);

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('tosou2021'),
        'name' => 'テスト業者' . $num,
        'kana' => 'テストギョウシャ' . $num,
        'prefectures' => $faker->numberBetween(0, 46),
        'city' => $faker->city,
        'address1' => $faker->streetAddress,
        'address2' => $faker->lastName . $faker->randomElement(['ビル', 'ヒルズ', '事務所', '工務店']) . $faker->buildingNumber,
        'category' => $faker->randomElement(['10', '20', '30', '40']),
        'rank' => $faker->numberBetween(0, 4),
        'message_key'=>md5(uniqid(rand(), true))
    ];
});
