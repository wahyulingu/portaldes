<?php

namespace Tests\Unit;

use App\Abstractions\Repository\Repository;
use App\Models\User;
use App\Repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    public function testRepositoryResolverIsWorking(): void
    {
        $this->assertInstanceOf(UserRepository::class, Repository::repositoryForModel(User::class));
    }

    public function testModelRepositoryResolverIsWorking()
    {
        $this->assertInstanceOf(UserRepository::class, User::repository());
    }
}
