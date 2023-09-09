<?php

namespace App\Policies\Content;

use App\Models\Content\ContentCategory;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.content.category');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentCategory $contentCategory): bool
    {
        return $user->can('view.content.category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.content.category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentCategory $contentCategory): bool
    {
        return $user->can('update.content.category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentCategory $contentCategory): bool
    {
        return $user->can('delete.content.category');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentCategory $contentCategory): bool
    {
        return $user->can('restore.content.category');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentCategory $contentCategory): bool
    {
        return $user->can('forceDelete.content.category');
    }
}
