<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'title' => fake()->text(20),
            'meta_title' => fake()->sentence(5),
            'slug' => fake()->slug(),
            'reading_time' => rand(1, 10),
            'summary' => fake()->text(255),
            'content' => fake()->realTextBetween(150, 420)
        ];
    }
}
