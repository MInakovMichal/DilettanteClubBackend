<?php

namespace Component\Punishment\Infrastructure\Repository;

use App\Models\Punishment;
use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
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
        return $this->entity->where('user_id', $userId)->get();
    }

    public function addPunishment(AddPunishmentContract $contract): Punishment
    {
        try {
            /** @var Punishment $punishment */
            $punishment = $this->entity::create([
                'user_id' => $contract->getUserId(),
                'punishment' => $contract->getPunishment(),
                'language_id' => $contract->getLanguageId(),
                'use_count' => 0,
            ]);/** @phpstan-ignore-line */

            return $punishment;
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }
}
