<?php

namespace Component\Room\Domain;

use Component\Room\Infrastructure\Service\RoomService;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Model\RoomRead;
use Component\Room\Sdk\RoomFacade;

class RoomFacadeImpl implements RoomFacade
{
    private RoomService $roomService;

    /**
     * @param RoomService $roomService
     */
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        return $this->roomService->createRoom($contract, $authUserId);
    }

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract): void
    {
        $this->roomService->addQuestionsToRoom($contract);
    }

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract): void
    {
        $this->roomService->addPunishmentsToRoom($contract);
    }

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void
    {
        $this->roomService->userEnterRoom($contract, $authUserId);
    }

    /**
     * @param int $roomId
     * @return array<int,mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->roomService->getUsersInRoom($roomId);
    }
}
