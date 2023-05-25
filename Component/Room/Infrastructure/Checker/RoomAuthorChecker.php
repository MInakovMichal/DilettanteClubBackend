<?php

namespace Component\Room\Infrastructure\Checker;

interface RoomAuthorChecker
{
    public function check(int $roomId, int $authUserId): void;
}
