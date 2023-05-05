<?php

namespace Component\Room\Infrastructure\Service;

use Component\Room\Infrastructure\Repository\RoomRepository;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Model\RoomRead;

class RoomServiceImpl implements RoomService
{
    private RoomRepository $repository;

    /**
     * @param RoomRepository $repository
     */
    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }


    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        return $this->repository->createRoom($contract, $authUserId);
    }
}
