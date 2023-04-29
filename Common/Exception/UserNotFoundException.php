<?php

declare(strict_types=1);

namespace Common\Exception;

class UserNotFoundException extends ApiException
{
    public const MESSAGE = "User not found with id: ";

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 404, ['user_id' => $id]);
    }
}
