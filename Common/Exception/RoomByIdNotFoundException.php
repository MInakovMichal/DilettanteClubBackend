<?php

declare(strict_types=1);

namespace Common\Exception;

class RoomByIdNotFoundException extends ApiException
{
    public const MESSAGE = "Room not found with id: ";

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 404, ['room_id' => $id]);
    }
}
