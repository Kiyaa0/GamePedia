<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;

class ForumPostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ForumPost $forumPost): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ForumPost $forumPost): bool
    {
        return $user->id === $forumPost->user_id || $user->role === 'admin';
    }

    public function delete(User $user, ForumPost $forumPost): bool
    {
        return $user->id === $forumPost->user_id || $user->role === 'admin';
    }
}
