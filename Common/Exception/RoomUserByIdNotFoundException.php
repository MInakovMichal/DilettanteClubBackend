<?php

declare(strict_types=1);

namespace Common\Exception;

class RoomUserByIdNotFoundException extends ApiException
{
    public const MESSAGE_FIRST_PART = "User not found with id: ";
    public const MESSAGE_SECOND_PART = " in room with id: ";

    public function __construct(int $id, int $roomId)
    {
        parent::__construct(
            self::MESSAGE_FIRST_PART . $id . self::MESSAGE_SECOND_PART . $roomId,
            404,
            ['user_id' => $id, 'room_id' => $roomId]
        );
    }
}
