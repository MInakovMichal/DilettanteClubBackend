<?php

declare(strict_types=1);

namespace Common\Auth\Domain\UserProvider;

use Common\Auth\Sdk\Model\Authenticate;

interface UserProvider
{
    public function isLoggedIn(): bool;

    public function current(): Authenticate;
}
