<?php

namespace Component\Room\Infrastructure\Service;

use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomPasswordChecker
{
    public function check(UserEnterRoomContract $contract): void;
}
