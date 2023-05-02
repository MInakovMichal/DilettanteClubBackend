<?php

declare(strict_types=1);

namespace Common\Exception;

class UserIsBlockedException extends ApiException
{
    public const MESSAGE = 'User is blocked with id: ';

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 403, ['user_id' => $id]);
    }
}
