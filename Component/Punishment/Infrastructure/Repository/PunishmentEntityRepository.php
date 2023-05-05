<?php

namespace Component\Punishment\Infrastructure\Repository;

use App\Models\Punishment;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Illuminate\Support\Collection;

interface PunishmentEntityRepository
{
    public function getAllPunishments(GetPunishmentsContract $contract): Collection;

    public function addPunishment(AddPunishmentContract $contract, int $authUserId): Punishment;

    public function deletePunishment(DeletePunishmentContract $contract, int $authUserId): void;

    public function updatePunishment(UpdatePunishmentContract $contract, int $authUserId): Punishment;

    public function findByIdOrFail(int $id): Punishment;
}
