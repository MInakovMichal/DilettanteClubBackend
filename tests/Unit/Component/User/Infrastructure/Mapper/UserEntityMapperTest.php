<?php

namespace Tests\Unit\Component\User\Infrastructure\Mapper;

use App\Models\User;
use Common\Exception\UserIsBlockedException;
use Common\Exception\UserIsNotVerifiedException;
use Component\User\Infrastructure\Mapper\UserEntityMapper;
use Component\User\Sdk\Model\UserRead;
use Tests\TestCase;

class UserEntityMapperTest extends TestCase
{
    private UserEntityMapper $mapper;

    public function test_MapToReadModel_ShouldReturnUserReadModel()
    {
        $user = User::factory()->make(['id' => 1]);
        $response = $this->mapper->mapToReadModel($user);
        $this->assertInstanceOf(UserRead::class, $response);
    }

    public function test_MapToReadModel_ShouldThrowUserIsNotVerifiedException_WhenUserNotVerifiedEmail()
    {
        $this->expectException(UserIsNotVerifiedException::class);
        $user = User::factory()->make(['id' => 1, 'email_verified_at' => null]);
        $this->mapper->mapToReadModel($user);
    }

    public function test_MapToReadModel_ShouldThrowUserIsBlockedException_WhenUserIsBlocked()
    {
        $this->expectException(UserIsBlockedException::class);
        $user = User::factory()->make(['id' => 1, 'is_blocked' => true]);
        $this->mapper->mapToReadModel($user);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = resolve(UserEntityMapper::class);
    }
}
