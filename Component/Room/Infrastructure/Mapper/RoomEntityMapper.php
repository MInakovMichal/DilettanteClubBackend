<?php

namespace Component\Room\Infrastructure\Mapper;

use App\Models\Room;
use Component\Room\Sdk\Model\RoomRead;

class RoomEntityMapper
{
    public function mapToReadModel(Room $room): RoomRead
    {
        return new RoomRead(
            $room->getId(),
            $room->getAuthorId(),
            $room->getName(),
            $room->isPrivate(),
            $room->getLanguageId()
        );
    }
}
