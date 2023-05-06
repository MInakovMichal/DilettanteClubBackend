<?php

namespace Component\Room\Infrastructure\Repository;

interface RoomDatabaseRepository
{
    /**
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array;
}
