<?php

namespace Component\Punishment\Infrastructure\Repository;

use App\Models\Punishment;
use Common\Exception\PunishmentByIdNotFoundException;
use Common\Exception\UnauthorizedException;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Throwable;
use UnexpectedValueException;

class PunishmentEntityRepositoryImpl implements PunishmentEntityRepository
{
    private Punishment $entity;

    public function __construct(Punishment $entity)
    {
        $this->entity = $entity;
    }

    public function getAllPunishments(GetPunishmentsContract $contract): Collection
    {
        $userId = $contract->getUserId();
        /** @var Collection $punishments */
        $punishments = $this->entity->where('user_id', $userId)->get();

        return $punishments;
    }

    public function addPunishment(AddPunishmentContract $contract, int $authUserId): Punishment
    {
        try {
            $punishment = new Punishment();

            $punishment->setPunishment($contract->getPunishment());
            $punishment->setUserId($authUserId);
            $punishment->setLanguageId($contract->getLanguageId());
            $punishment->setLanguageId($contract->getLanguageId());
            $punishment->setUseCount(0);
            $punishment->save();

            return $punishment;
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }

    public function deletePunishment(DeletePunishmentContract $contract, int $authUserId): void
    {
        $punishment = self::findByIdOrFail($contract->getPunishmentId());
        if ($punishment->getUserId() === $authUserId) {
            $punishment->delete();
        } else {
            throw new UnauthorizedException();
        }
    }

    public function findByIdOrFail(int $id): Punishment
    {
        try {
            /** @var Punishment $punishment */
            $punishment = $this->entity->findOrFail($id);
            return $punishment;
        } catch (ModelNotFoundException $e) {
            throw new PunishmentByIdNotFoundException($id);
        }
    }

    public function updatePunishment(UpdatePunishmentContract $contract, int $authUserId): Punishment
    {
        $punishment = self::findByIdOrFail($contract->getPunishmentId());

        if ($punishment->getUserId() === $authUserId) {
            $punishment->setPunishment($contract->getPunishment());
            $punishment->setLanguageId($contract->getLanguageId());

            $punishment->save();
            return $punishment;
        } else {
            throw new UnauthorizedException();
        }
    }
}
