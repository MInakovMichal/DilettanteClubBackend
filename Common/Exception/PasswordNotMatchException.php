<?php

declare(strict_types=1);

namespace Common\Exception;

class PasswordNotMatchException extends ApiException
{
    public const MESSAGE = "Password is not match";

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 401);
    }
}
