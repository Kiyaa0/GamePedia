<?php

namespace Database\Factories;

use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ForumReply>
 */
class ForumReplyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'forum_post_id' => ForumPost::factory(),
            'user_id' => User::factory(),
            'body' => fake()->paragraphs(2, true),
        ];
    }
}
