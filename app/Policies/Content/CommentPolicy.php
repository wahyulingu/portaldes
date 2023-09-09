<?php

namespace App\Policies\Content;

use App\Models\Content\ContentComment;
use App\Models\User;

class CommentPolicy
{
    protected function userMatch(User $user, ContentComment $comment): bool
    {
        return $user->getKey() == $comment->user->getKey();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.content.comment');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentComment $comment): bool
    {
        return $user->can('view.content.comment') || $this->userMatch($user, $comment);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.content.comment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentComment $comment): bool
    {
        return $user->can('update.content.comment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentComment $comment): bool
    {
        return $user->can('delete.content.comment') || $this->userMatch($user, $comment);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentComment $comment): bool
    {
        return $user->can('restore.content.comment');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentComment $comment): bool
    {
        return $user->can('forceDelete.content.comment') || $this->userMatch($user, $comment);
    }
}
