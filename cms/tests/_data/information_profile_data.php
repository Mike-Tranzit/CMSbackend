<?php
$faker = \Faker\Factory::create('ru_RU');
return [
    'user' => [
        'name' => $faker->name,
        'company' => $faker->company,
        'password' => 1111
    ] 
];