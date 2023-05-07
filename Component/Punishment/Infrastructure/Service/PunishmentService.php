<?php

namespace Component\Punishment\Infrastructure\Service;

use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Illuminate\Support\Collection;

interface PunishmentService
{
    public function getAllPunishments(GetPunishmentsContract $contract): Collection;

    public function addPunishment(AddPunishmentContract $contract, int $authUserId): PunishmentRead;

    public function deletePunishment(DeletePunishmentContract $contract, int $authUserId): void;

    public function updatePunishment(UpdatePunishmentContract $contract, int $authUserId): PunishmentRead;

    public function findByIdOrFail(int $punishmentId): PunishmentRead;
}
