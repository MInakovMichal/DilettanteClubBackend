<?php

declare(strict_types=1);

namespace Common\Exception;

class RoomPunishmentByIdNotFoundException extends ApiException
{
    public const MESSAGE_FIRST_PART = "Punishment not found with id: ";
    public const MESSAGE_SECOND_PART = " in room with id: ";

    public function __construct(int $id, int $roomId)
    {
        parent::__construct(
            self::MESSAGE_FIRST_PART . $id . self::MESSAGE_SECOND_PART . $roomId,
            404,
            ['punishment_id' => $id, 'room_id' => $roomId]
        );
    }
}
