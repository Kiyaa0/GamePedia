<?php

namespace App\Policies;

use App\Models\ForumReply;
use App\Models\User;

class ForumReplyPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ForumReply $forumReply): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ForumReply $forumReply): bool
    {
        return $user->id === $forumReply->user_id || $user->role === 'admin';
    }

    public function delete(User $user, ForumReply $forumReply): bool
    {
        return $user->id === $forumReply->user_id || $user->role === 'admin';
    }
}
