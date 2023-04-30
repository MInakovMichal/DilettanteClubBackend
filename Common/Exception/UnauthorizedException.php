<?php

declare(strict_types=1);

namespace Common\Exception;

class UnauthorizedException extends ApiException
{
    public const MESSAGE = 'Unauthorized request.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 401);
    }
}
