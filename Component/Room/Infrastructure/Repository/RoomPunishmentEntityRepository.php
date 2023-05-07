<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomPunishment;

interface RoomPunishmentEntityRepository
{
    public function addPunishmentToRoom(int $roomId, int $punishmentId): void;

    public function deletePunishmentFromRoom(int $roomId, int $punishmentId): void;

    public function findByIdAndRoomIdOrFail(int $roomId, int $punishmentId): RoomPunishment;
}
