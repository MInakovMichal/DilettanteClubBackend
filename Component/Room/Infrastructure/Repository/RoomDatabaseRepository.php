<?php

namespace Component\Room\Infrastructure\Repository;

interface RoomDatabaseRepository
{
    /**
     * @param int $roomId
     * @return array<int,mixed>
     */
    public function getUsersInRoom(int $roomId): array;
}
