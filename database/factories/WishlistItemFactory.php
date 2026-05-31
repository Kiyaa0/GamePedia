<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WishlistItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WishlistItem>
 */
class WishlistItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'rawg_game_id' => (string) fake()->unique()->numberBetween(1, 999999),
            'game_title' => fake()->words(3, true),
            'game_image' => fake()->imageUrl(),
            'status' => fake()->randomElement(['want_to_buy', 'owned', 'playing']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
