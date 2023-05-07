<?php

namespace Component\Room\Infrastructure\Checker;

use Common\Exception\InvalidArgumentException;
use Component\Room\Infrastructure\Repository\RoomEntityRepository;
use Component\Room\Sdk\Contract\CloseRoomContract;

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


    public function check(CloseRoomContract $contract, int $authUserId): void
    {
        $room = $this->repository->findByIdOrFail($contract->getRoomId());

        if ($room->getUserId() !== $authUserId) {
            throw new InvalidArgumentException('Can not remove not your own room');
        }
    }
}
