<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->postcode,
        'description' => $faker->text,
        'image' => $faker->imageUrl($width = 300, $height = 150),
        'slug' => $faker->slug
    ];
});
