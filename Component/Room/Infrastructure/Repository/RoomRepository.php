<?php

namespace Component\Room\Infrastructure\Repository;

use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomRepository
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead;
}
