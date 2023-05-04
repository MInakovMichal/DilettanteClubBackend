<?php

declare(strict_types=1);

namespace Common\Exception;

class PunishmentByIdNotFoundException extends ApiException
{
    public const MESSAGE = "Punishment not found with id: ";

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 404, ['punishment_id' => $id]);
    }
}
