<?php

namespace Component\Room\Sdk;

use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomFacade
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead;
}
