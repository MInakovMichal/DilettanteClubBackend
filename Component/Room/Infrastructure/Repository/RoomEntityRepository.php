<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\Room;
use Component\Room\Sdk\Contract\CloseRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;

interface RoomEntityRepository
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): Room;

    public function findByIdOrFail(int $id): Room;

    public function closeRoom(CloseRoomContract $contract, int $authUserId): void;
}
