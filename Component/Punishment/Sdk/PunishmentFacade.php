<?php

namespace Component\Punishment\Sdk;

use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Illuminate\Support\Collection;

interface PunishmentFacade
{
    public function getAllPunishments(GetPunishmentsContract $contract): Collection;

    public function addPunishment(AddPunishmentContract $contract, int $authUserId): PunishmentRead;

    public function deletePunishment(DeletePunishmentContract $contract, int $authUserId): void;

    public function updatePunishment(UpdatePunishmentContract $contract, int $authUserId): PunishmentRead;

}
