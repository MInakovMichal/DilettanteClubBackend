<?php

namespace Component\Room\Infrastructure\Repository;

use Component\Room\Infrastructure\Mapper\RoomEntityMapper;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Model\RoomRead;

class RoomRepositoryImpl implements RoomRepository
{
    private RoomEntityRepository $repository;

    private RoomEntityMapper $entityMapper;

    /**
     * @param RoomEntityRepository $repository
     * @param RoomEntityMapper $entityMapper
     */
    public function __construct(RoomEntityRepository $repository, RoomEntityMapper $entityMapper)
    {
        $this->repository = $repository;
        $this->entityMapper = $entityMapper;
    }


    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        return $this->entityMapper->mapToReadModel($this->repository->createRoom($contract, $authUserId));
    }
}
