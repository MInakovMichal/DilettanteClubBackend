<?php

declare(strict_types=1);

namespace Common\Exception;

class UserEmailIsNotSetException extends ApiException
{
    public const MESSAGE = 'User does not have an email with id: ';

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 403, ['user_id' => $id]);
    }
}
