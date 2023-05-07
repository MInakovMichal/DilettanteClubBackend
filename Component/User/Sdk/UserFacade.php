<?php

namespace Component\User\Sdk;

use Common\Auth\Sdk\Contract\RegisterContract;
use Common\ValueObject\Email;
use Component\User\Sdk\Model\UserRead;

interface UserFacade
{
    public function createUser(RegisterContract $contract): UserRead;

    public function findByEmailOrFail(Email $email): UserRead;

    public function findByIdOrFail(int $id): UserRead;

    public function addRoomToUser(int $authUserId, int $roomId): void;

    public function deleteRoomFromUser(int $authUserId): void;
}
