<?php

namespace App\Repositories;

use App\Abstractions\Repository\Repository;
use App\Models\User;

/**
 * @extends Repository<User>
 */
class UserRepository extends Repository
{
    /*
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
}
