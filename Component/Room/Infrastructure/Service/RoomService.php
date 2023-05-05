<?php

namespace Component\Room\Infrastructure\Service;

use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomService
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead;
}
