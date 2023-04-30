<?php

namespace Component\User\Domain;

use Common\Auth\Sdk\Contract\RegisterContract;
use Common\ValueObject\Email;
use Component\User\Infrastructure\Service\UserService;
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

    public function findByEmailOrFail(Email $email): UserRead
    {
        return $this->userService->findByEmailOrFail($email);
    }

    public function findByIdOrFail(int $id): UserRead
    {
        return $this->userService->findByIdOrFail($id);
    }
}
