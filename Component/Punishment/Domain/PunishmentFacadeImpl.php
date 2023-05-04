<?php

namespace Component\Punishment\Domain;

use Component\Punishment\Infrastructure\Service\PunishmentService;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Component\Punishment\Sdk\PunishmentFacade;
use Illuminate\Support\Collection;

class PunishmentFacadeImpl implements PunishmentFacade
{
    private PunishmentService $punishmentService;

    /**
     * @param PunishmentService $punishmentService
     */
    public function __construct(PunishmentService $punishmentService)
    {
        $this->punishmentService = $punishmentService;
    }

    public function getAllPunishments(GetPunishmentsContract $contract): Collection
    {
        return $this->punishmentService->getAllPunishments($contract);
    }

    public function addPunishment(AddPunishmentContract $contract, int $authUserId): PunishmentRead
    {
        return $this->punishmentService->addPunishment($contract, $authUserId);
    }

    public function deletePunishment(DeletePunishmentContract $contract, int $authUserId): void
    {
        $this->punishmentService->deletePunishment($contract, $authUserId);
    }

    public function updatePunishment(UpdatePunishmentContract $contract, int $authUserId): PunishmentRead
    {
        return $this->punishmentService->updatePunishment($contract, $authUserId);
    }

}
