<?php

namespace Component\Punishment\Infrastructure\Service;

use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Illuminate\Support\Collection;

interface PunishmentService
{
    public function getAllPunishments(GetPunishmentsContract $contract): Collection;

    public function addPunishment(AddPunishmentContract $contract): PunishmentRead;
}
