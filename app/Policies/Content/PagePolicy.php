<?php

namespace App\Policies\Content;

use App\Models\Content\ContentPage;
use App\Models\User;

class PagePolicy
{
    protected function userMatch(User $user, ContentPage $page): bool
    {
        return $user->getKey() == $page->user->getKey();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.content.page');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentPage $page): bool
    {
        return $user->can('view.content.page') || $this->userMatch($user, $page);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.content.page');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentPage $page): bool
    {
        return $user->can('update.content.page') || $this->userMatch($user, $page);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentPage $page): bool
    {
        return $user->can('delete.content.page') || $this->userMatch($user, $page);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentPage $page): bool
    {
        return $user->can('restore.content.page') || $this->userMatch($user, $page);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentPage $page): bool
    {
        return $user->can('forceDelete.content.page') || $this->userMatch($user, $page);
    }
}
