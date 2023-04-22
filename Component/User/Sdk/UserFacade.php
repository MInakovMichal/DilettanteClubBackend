<?php

namespace Component\User\Sdk;

use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\Model\UserRead;

interface UserFacade
{
    public function createUser(RegisterContract $contract): UserRead;
}
