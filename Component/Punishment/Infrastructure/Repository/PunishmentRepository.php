<?php

namespace Component\Punishment\Infrastructure\Repository;

use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Illuminate\Support\Collection;

interface PunishmentRepository
{
    public function getAllPunishments(GetPunishmentsContract $contract): Collection;

    public function addPunishment(AddPunishmentContract $contract): PunishmentRead;
}
