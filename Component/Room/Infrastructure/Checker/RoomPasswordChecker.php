<?php

namespace Component\Room\Infrastructure\Checker;

use Component\Room\Sdk\Contract\UserEnterRoomContract;

interface RoomPasswordChecker
{
    public function check(UserEnterRoomContract $contract): void;
}
