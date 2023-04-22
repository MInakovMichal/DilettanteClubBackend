<?php

namespace Component\User\Infrastructure\Repository;

use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\Model\UserRead;

interface UserRepository
{
    public function createUser(RegisterContract $contract): UserRead;
}
