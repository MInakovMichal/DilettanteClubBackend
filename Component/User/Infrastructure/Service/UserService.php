<?php

namespace Component\User\Infrastructure\Service;

use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\Model\UserRead;

interface UserService
{
    public function createUser(RegisterContract $contract): UserRead;
}
