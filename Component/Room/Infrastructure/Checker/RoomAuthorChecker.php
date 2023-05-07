<?php

namespace Component\Room\Infrastructure\Checker;

use Component\Room\Sdk\Contract\CloseRoomContract;

interface RoomAuthorChecker
{
    public function check(CloseRoomContract $contract, int $authUserId): void;
}
