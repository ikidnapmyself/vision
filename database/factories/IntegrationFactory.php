<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Integration;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Integration::class, function (Faker $faker) {
    $user     = User::inRandomOrder()->first() ?? factory(User::class)->create();
    $provider = collect(['github', 'discord', 'spotify', 'youtube', 'instagram', 'twitter'])->random();

    return [
        'user_id'       => $user->id,
        'provider_name' => $provider,
        'provider_id'   => "{$provider}-" . Str::uuid(),
        'access_token'  => "{$provider}-access-token-" . Str::random(10),
        'refresh_token' => "{$provider}-refresh-token-" . Str::random(10),
        'profile'       => $user->only(['full_name', 'email']),
    ];
});
