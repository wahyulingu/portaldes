<?php

namespace App\Abstractions\Action\Content;

use App\Models\User;

abstract class ContentIndexByUserAction extends ContentIndexAction
{
    protected User $user;

    public function prepare(User $user)
    {
        return tap($this, fn (self $action) => $action->user = $user);
    }

    protected function filters(array $payload = []): array
    {
        return ['user' => $this->user];
    }
}
