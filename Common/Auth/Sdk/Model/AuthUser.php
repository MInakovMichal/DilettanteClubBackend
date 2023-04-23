<?php

declare(strict_types=1);

namespace Common\Auth\Sdk\Model;

use Carbon\Carbon;
use Common\ValueObject\Email;
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
}
