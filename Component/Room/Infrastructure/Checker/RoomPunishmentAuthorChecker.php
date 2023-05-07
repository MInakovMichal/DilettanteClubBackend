<?php

namespace Component\Room\Infrastructure\Checker;

interface RoomPunishmentAuthorChecker
{
    public function check(int $punishmentId, int $userId): void;
}
