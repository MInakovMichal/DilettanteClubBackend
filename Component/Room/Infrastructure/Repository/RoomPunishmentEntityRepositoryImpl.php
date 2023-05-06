<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomPunishment;
use Throwable;
use UnexpectedValueException;

class RoomPunishmentEntityRepositoryImpl implements RoomPunishmentEntityRepository
{
    public function addPunishmentToRoom(int $roomId, int $punishmentId): void
    {
        try {
            $roomPunishment = new RoomPunishment();
            $roomPunishment->setRoomId($roomId);
            $roomPunishment->setPunishmentId($punishmentId);
            $roomPunishment->setInGame(false);
            $roomPunishment->setIsUsed(false);
            $roomPunishment->save();
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }
}
