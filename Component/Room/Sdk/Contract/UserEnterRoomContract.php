<?php

namespace Component\Room\Sdk\Contract;

interface UserEnterRoomContract
{
    public function getRoomId(): int;

    public function hasPassword(): bool;

    public function getPassword(): string;

    public function isPrivate(): bool;
}
