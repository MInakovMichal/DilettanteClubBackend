<?php

declare(strict_types=1);

namespace Common\Exception;

class UserIsNotInRoomException extends ApiException
{
    public const MESSAGE = 'User is not in room';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 403);
    }
}
