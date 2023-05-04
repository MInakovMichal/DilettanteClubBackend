<?php

namespace Component\Punishment\Infrastructure\Service;

use Component\Punishment\Infrastructure\Repository\PunishmentRepository;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Illuminate\Support\Collection;

class PunishmentServiceImpl implements PunishmentService
{
    private PunishmentRepository $punishmentRepository;

    public function __construct(PunishmentRepository $punishmentRepository)
    {
        $this->punishmentRepository = $punishmentRepository;
    }

    public function getAllPunishments(GetPunishmentsContract $contract): Collection
    {
        return $this->punishmentRepository->getAllPunishments($contract);
    }

    public function addPunishment(AddPunishmentContract $contract, int $authUserId): PunishmentRead
    {
        return $this->punishmentRepository->addPunishment($contract, $authUserId);
    }

    public function deletePunishment(DeletePunishmentContract $contract, int $authUserId): void
    {
        $this->punishmentRepository->deletePunishment($contract, $authUserId);
    }

    public function updatePunishment(UpdatePunishmentContract $contract, int $authUserId): PunishmentRead
    {
        return $this->punishmentRepository->updatePunishment($contract, $authUserId);
    }

}
