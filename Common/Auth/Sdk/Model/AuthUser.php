<?php

declare(strict_types=1);

namespace Common\Auth\Sdk\Model;

use Common\Exception\UserIsNotInRoomException;
use Component\User\Sdk\Model\UserRead;

final class AuthUser
{
    private UserRead $user;

    public function __construct(UserRead $user)
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->user->getId();
    }

    public function getName(): string
    {
        return $this->user->getName();
    }

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    public function getRoomId(): int
    {
        if (!self::isInRoom()) {
            throw new UserIsNotInRoomException();
        }
        return $this->user->getRoomId();
    }

    public function isInRoom(): bool
    {
        return $this->user->isInRoom();
    }
}
