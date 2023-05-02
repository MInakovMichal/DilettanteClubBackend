<?php

declare(strict_types=1);

namespace Component\Punishment\Infrastructure\Mapper;

use App\Models\Punishment;
use Component\Punishment\Sdk\Model\PunishmentRead;

final class PunishmentEntityMapper
{
    public function mapToReadModel(Punishment $punishmentEntity): PunishmentRead
    {
        return new PunishmentRead(
            $punishmentEntity->getId(),
            $punishmentEntity->getUserId(),
            $punishmentEntity->getPunishment(),
            $punishmentEntity->getUseCount(),
            $punishmentEntity->getLanguageId(),
        );
    }
}
