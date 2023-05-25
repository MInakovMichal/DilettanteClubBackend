<?php

namespace Tests\Unit\Common\Auth\Infrastructure\Mapper;

use Common\Auth\Infrastructure\Mapper\UserProviderMapper;
use Common\Auth\Sdk\Model\Authenticate;
use Component\User\Sdk\Model\UserRead;
use Tests\TestCase;

class UserProviderMapperTest extends TestCase
{
    public function test_MapToAuthenticate_ShouldReturnAuthenticateClass(): void
    {
        $token = 'token example';

        $userRead = new UserRead(
            1,
            $this->faker->name(),
            $this->faker->userName(),
            $this->faker->email(),
            false
        );

        $authenticateClass = app(UserProviderMapper::class);

        $authenticate = $authenticateClass->mapToAuthenticate($token, $userRead);

        $this->assertInstanceOf(Authenticate::class, $authenticate);
    }
}
