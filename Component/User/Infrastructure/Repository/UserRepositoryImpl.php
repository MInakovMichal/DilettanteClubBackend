<?php

namespace Component\User\Infrastructure\Repository;

use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\Model\UserRead;

class UserRepositoryImpl implements UserRepository
{
    private UserEntityRepository $entityRepository;

    public function __construct(UserEntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function createUser(RegisterContract $contract): UserRead
    {
        return $this->entityRepository->createUser($contract);
    }
}
