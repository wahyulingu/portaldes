<?php

namespace App\Policies\Content;

use App\Models\Content\ContentArticle;
use App\Models\User;

class ArticlePolicy
{
    protected function userMatch(User $user, ContentArticle $article): bool
    {
        return $user->getKey() == $article->user->getKey();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.content.article');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentArticle $article): bool
    {
        return $user->can('view.content.article') || $this->userMatch($user, $article);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.content.article');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentArticle $article): bool
    {
        return $user->can('update.content.article') || $this->userMatch($user, $article);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentArticle $article): bool
    {
        return $user->can('delete.content.article') || $this->userMatch($user, $article);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentArticle $article): bool
    {
        return $user->can('restore.content.article') || $this->userMatch($user, $article);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentArticle $article): bool
    {
        return $user->can('forceDelete.content.article') || $this->userMatch($user, $article);
    }
}
