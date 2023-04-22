<?php

declare(strict_types=1);

namespace Component\User\Sdk\Exception;

use Common\Exception\ApiException;

class UserIsNotVerifiedException extends ApiException
{
    public const MESSAGE = 'User is not verified with id: ';

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 403, ['user_id' => $id]);
    }
}
