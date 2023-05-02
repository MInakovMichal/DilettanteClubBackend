<?php

declare(strict_types=1);

namespace Component\User\Infrastructure\Mapper;

use App\Models\User;
use Common\Exception\UserIsBlockedException;
use Common\Exception\UserIsNotVerifiedException;
use Component\User\Sdk\Model\UserRead;

final class UserEntityMapper
{
    public function mapToReadModel(User $userEntity): UserRead
    {
        $id = $userEntity->getId();

        if ($userEntity->isBlocked()) {
            throw new UserIsBlockedException($id);
        }

        if (! $userEntity->isVerified()) {
            throw new UserIsNotVerifiedException($id);
        }

        return new UserRead(
            $id,
            $userEntity->getName(),
            $userEntity->getUserName(),
            $userEntity->getEmail()
        );
    }
}
