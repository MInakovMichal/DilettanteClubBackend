<?php

namespace Component\User\Infrastructure\Repository;

use Common\Auth\Sdk\Contract\RegisterContract;
use Common\ValueObject\Email;
use Common\ValueObject\Uuid;
use Component\User\Infrastructure\Mapper\UserEntityMapper;
use Component\User\Sdk\Model\UserRead;

class UserRepositoryImpl implements UserRepository
{
    private UserEntityRepository $entityRepository;

    private UserEntityMapper $userEntityMapper;

    public function __construct(UserEntityRepository $entityRepository, UserEntityMapper $userEntityMapper)
    {
        $this->entityRepository = $entityRepository;
        $this->userEntityMapper = $userEntityMapper;
    }

    public function createUser(RegisterContract $contract): UserRead
    {
        $user = $this->entityRepository->createUser($contract);
        return $this->userEntityMapper->mapToReadModel($user);
    }

    public function findByEmailOrFail(Email $email): UserRead
    {
        $user = $this->entityRepository->findByEmailOrFail($email);
        return $this->userEntityMapper->mapToReadModel($user);
    }

    public function findByIdOrFail(int $id): UserRead
    {
        $user = $this->entityRepository->findByIdOrFail($id);
        return $this->userEntityMapper->mapToReadModel($user);
    }
}
