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
    public function definition(): array
    {
        return [
            'title' => substr(fake()->sentence(), 0, 60),
            'content' => fake()->paragraphs(3, true),
            'user_id' => 1,
            'published_date' => fake()->dateTimeBetween('-2 month', '+2 month'),
            'status' => fake()->randomElement(['draft', 'scheduled', 'active']),
        ];
    }
}