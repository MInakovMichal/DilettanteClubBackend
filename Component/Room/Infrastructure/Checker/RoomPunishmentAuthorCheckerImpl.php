<?php

namespace Component\Room\Infrastructure\Checker;

use Common\Exception\InvalidArgumentException;
use Component\Punishment\Sdk\PunishmentFacade;

class RoomPunishmentAuthorCheckerImpl implements RoomPunishmentAuthorChecker
{
    private PunishmentFacade $punishmentFacade;

    /**
     * @param PunishmentFacade $punishmentFacade
     */
    public function __construct(PunishmentFacade $punishmentFacade)
    {
        $this->punishmentFacade = $punishmentFacade;
    }

    public function check(int $punishmentId, int $userId): void
    {
        $punishment = $this->punishmentFacade->findByIdOrFail($punishmentId);

        if ($punishment->getUserId() !== $userId) {
            throw new InvalidArgumentException('Can not delete punishment from room with id: ' . $punishmentId);
        }
    }
}
