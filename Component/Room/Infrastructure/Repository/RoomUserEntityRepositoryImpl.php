<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomUser;
use Throwable;
use UnexpectedValueException;

class RoomUserEntityRepositoryImpl implements RoomUserEntityRepository
{
    public function userEnterRoom(int $roomId, int $authUserId): void
    {
        try {
            $roomUser = new RoomUser();
            $roomUser->setUserId($authUserId);
            $roomUser->setRoomId($roomId);
            $roomUser->setIsReady(false);
            $roomUser->setWins(0);
            $roomUser->setLooses(0);
            $roomUser->save();
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }
}
