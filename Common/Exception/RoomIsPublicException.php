<?php

declare(strict_types=1);

namespace Common\Exception;

class RoomIsPublicException extends ApiException
{
    public const MESSAGE = "The room is public";

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 400);
    }
}
