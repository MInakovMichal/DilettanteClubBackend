<?php

declare(strict_types=1);

namespace Common\Exception;

class UserWithProvidedCredentialsNotFoundException extends ApiException
{
    public const MESSAGE = "Account with provided credentials not found";

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 400);
    }
}
