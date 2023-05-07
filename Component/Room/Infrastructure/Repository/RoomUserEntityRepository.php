<?php

namespace Component\Room\Infrastructure\Repository;

interface RoomUserEntityRepository
{
    public function userEnterRoom(int $roomId, int $authUserId): void;

    public function userLeaveRoom(int $roomId, int $authUserId): void;
}
