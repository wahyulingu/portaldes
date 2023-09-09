<?php

namespace App\Abstractions\Action\Content\Index;

use App\Models\User;

abstract class ContentIndexByUserAction extends ContentIndexAction
{
    protected User $user;

    public function prepare(User $user)
    {
        return tap($this, fn (self $action) => $action->user = $user);
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->repository->index(['user' => $this->user], @$validatedPayload['limit'] ?: 0);
    }
}
