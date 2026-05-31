<?php

namespace Database\Factories;

use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ForumPost>
 */
class ForumPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'rawg_game_id' => (string) fake()->numberBetween(1, 999999),
            'game_title' => fake()->words(3, true),
            'title' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
        ];
    }
}
