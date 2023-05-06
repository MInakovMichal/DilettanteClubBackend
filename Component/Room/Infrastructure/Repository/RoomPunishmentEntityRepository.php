<?php

namespace Component\Room\Infrastructure\Repository;

interface RoomPunishmentEntityRepository
{
    public function addPunishmentToRoom(int $roomId, int $punishmentId): void;
}
