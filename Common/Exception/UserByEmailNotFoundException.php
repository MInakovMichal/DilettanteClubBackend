<?php

declare(strict_types=1);

namespace Common\Exception;

class UserByEmailNotFoundException extends ApiException
{
    public const MESSAGE = "User not found with email: ";

    public function __construct(string $email)
    {
        parent::__construct(self::MESSAGE . $email, 404, ['user_email' => $email]);
    }
}
