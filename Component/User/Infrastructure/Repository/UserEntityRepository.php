<?php

namespace Component\User\Infrastructure\Repository;

use App\Models\User;
use Common\Auth\Sdk\Contract\RegisterContract;
use Common\ValueObject\Email;

interface UserEntityRepository
{
    public function createUser(RegisterContract $contract): User;

    public function findByEmailOrFail(Email $email): User;

    public function findByIdOrFail(int $id): User;
}
