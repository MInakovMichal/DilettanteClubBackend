<?php

namespace Component\Room\Domain;

use Component\Room\Infrastructure\Service\RoomService;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CloseRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\DeletePunishmentsFromRoomContract;
use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Contract\UserLeaveRoomContract;
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
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->roomService->getUsersInRoom($roomId);
    }

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomContract $contract, int $authUserId): void
    {
        $this->roomService->deleteQuestionsFromRoom($contract, $authUserId);
    }

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomContract $contract, int $authUserId): void
    {
        $this->roomService->deletePunishmentsFromRoom($contract, $authUserId);
    }

    public function userLeaveRoom(UserLeaveRoomContract $contract, int $authUserId): void
    {
        $this->roomService->userLeaveRoom($contract, $authUserId);
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserQuestionsInRoom(int $authUserId, int $roomId): array
    {
        return $this->roomService->getAllUserQuestionsInRoom($authUserId, $roomId);
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserPunishmentsInRoom(int $authUserId, int $roomId): array
    {
        return $this->roomService->getAllUserPunishmentsInRoom($authUserId, $roomId);
    }

    public function closeRoom(CloseRoomContract $contract, int $authUserId): void
    {
        $this->roomService->closeRoom($contract, $authUserId);
    }

    public function findByIdOrFail(int $id): RoomRead
    {
        return $this->roomService->findByIdOrFail($id);
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getAllPublicRoomsWithUsersCount(): array
    {
        return $this->roomService->getAllPublicRoomsWithUsersCount();
    }
}
