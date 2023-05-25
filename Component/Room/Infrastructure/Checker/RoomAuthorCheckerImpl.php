<?php

namespace Component\Room\Infrastructure\Checker;

use Common\Exception\InvalidArgumentException;
use Component\Room\Infrastructure\Repository\RoomEntityRepository;

class RoomAuthorCheckerImpl implements RoomAuthorChecker
{
    private RoomEntityRepository $repository;

    /**
     * @param RoomEntityRepository $repository
     */
    public function __construct(RoomEntityRepository $repository)
    {
        $this->repository = $repository;
    }


    public function check(int $roomId, int $authUserId): void
    {
        $room = $this->repository->findByIdOrFail($roomId);

        if ($room->getUserId() !== $authUserId) {
            throw new InvalidArgumentException('Can not remove not your own room');
        }
    }
}
