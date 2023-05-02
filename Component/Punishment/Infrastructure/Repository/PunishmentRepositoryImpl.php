<?php

namespace Component\Punishment\Infrastructure\Repository;

use Component\Punishment\Infrastructure\Mapper\PunishmentEntityMapper;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Illuminate\Support\Collection;

class PunishmentRepositoryImpl implements PunishmentRepository
{
    private PunishmentEntityRepository $entityRepository;

    private PunishmentEntityMapper $entityMapper;

    public function __construct(PunishmentEntityRepository $entityRepository, PunishmentEntityMapper $entityMapper)
    {
        $this->entityRepository = $entityRepository;
        $this->entityMapper = $entityMapper;
    }

    public function getAllPunishments(GetPunishmentsContract $contract): Collection
    {
        return $this->entityRepository->getAllPunishments($contract);
    }

    public function addPunishment(AddPunishmentContract $contract): PunishmentRead
    {
        return $this->entityMapper->mapToReadModel($this->entityRepository->addPunishment($contract));
    }
}
