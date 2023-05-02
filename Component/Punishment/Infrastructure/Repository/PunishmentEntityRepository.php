<?php

namespace Component\Punishment\Infrastructure\Repository;

use App\Models\Punishment;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Illuminate\Support\Collection;

interface PunishmentEntityRepository
{
    public function getAllPunishments(GetPunishmentsContract $contract): Collection;

    public function addPunishment(AddPunishmentContract $contract): Punishment;
}
