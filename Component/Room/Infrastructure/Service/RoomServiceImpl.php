<?php

namespace Component\Room\Infrastructure\Service;

use Component\Room\Infrastructure\Repository\RoomRepository;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
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

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract): void
    {
        $this->repository->addQuestionsToRoom($contract);
    }

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract): void
    {
        $this->repository->addPunishmentsToRoom($contract);
    }

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void
    {
        $this->repository->userEnterRoom($contract, $authUserId);
    }

    /**
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->repository->getUsersInRoom($roomId);
    }

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomContract $contract, int $authUserId): void
    {
        $this->repository->deleteQuestionsFromRoom($contract, $authUserId);
    }
}
