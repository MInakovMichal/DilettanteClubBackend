<?php

namespace Component\User\Infrastructure\Service;

use Common\Auth\Sdk\Contract\RegisterContract;
use Common\ValueObject\Email;
use Component\User\Infrastructure\Repository\UserRepository;
use Component\User\Sdk\Model\UserRead;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(RegisterContract $contract): UserRead
    {
        return $this->userRepository->createUser($contract);
    }

    public function findByEmailOrFail(Email $email): UserRead
    {
        return $this->userRepository->findByEmailOrFail($email);
    }

    public function findByIdOrFail(int $id): UserRead
    {
        return $this->userRepository->findByIdOrFail($id);
    }
}
