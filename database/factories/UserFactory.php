<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $salt = "UNHEX(SHA1(CONCAT(RAND(), RAND(), RAND())))";
        $password = "UNHEX(SHA1(CONCAT(HEX($salt), 'password')))";

        return [
            'username' => fake()->userName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'mobile_phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => DB::raw($password), // password
            'salt' => DB::raw($salt),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
