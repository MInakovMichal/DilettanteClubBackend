<?php

namespace Component\User\Domain;

use Component\User\Infrastructure\Service\UserService;
use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\Model\UserRead;
use Component\User\Sdk\UserFacade;

class UserFacadeImpl implements UserFacade
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(RegisterContract $contract): UserRead
    {
        return $this->userService->createUser($contract);
    }
}
