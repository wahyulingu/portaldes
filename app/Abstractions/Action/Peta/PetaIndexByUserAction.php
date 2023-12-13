<?php

namespace App\Abstractions\Action\Peta;

use App\Models\User;

abstract class PetaIndexByUserAction extends PetaIndexAction
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
