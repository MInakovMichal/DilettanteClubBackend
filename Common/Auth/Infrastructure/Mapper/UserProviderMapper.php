<?php

declare(strict_types=1);

namespace Common\Auth\Infrastructure\Mapper;

use Common\Auth\Sdk\Model\Authenticate;
use Common\Auth\Sdk\Model\AuthUser;
use Component\User\Sdk\Model\UserRead;

final class UserProviderMapper
{
    public function mapToAuthenticate(string $token, UserRead $user): Authenticate
    {
        return new Authenticate($token, new AuthUser($user));
    }
}
