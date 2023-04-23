<?php

declare(strict_types=1);

namespace Common\Auth\Sdk\Contract;

use Common\ValueObject\RoleValueObject;

interface LoginContract
{
    public function getDeviceToken(): string;

    public function hasRole(): bool;

    public function getRole(): RoleValueObject;

    public function hasEmail(): bool;

    public function getEmail(): string;

    public function getPassword(): string;
}
