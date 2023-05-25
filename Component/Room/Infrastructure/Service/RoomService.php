<?php

namespace Component\Room\Infrastructure\Service;

use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\DeletePunishmentsFromRoomContract;
use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomService
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead;

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract, int $roomId): void;

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract, int $roomId): void;

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void;

    /**
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array;

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomContract $contract, int $authUserId, int $roomId): void;

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomContract $contract, int $authUserId, int $roomId): void;

    public function userLeaveRoom(int $roomId, int $authUserId): void;

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserQuestionsInRoom(int $authUserId, int $roomId): array;

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserPunishmentsInRoom(int $authUserId, int $roomId): array;

    public function closeRoom(int $roomId, int $authUserId): void;

    public function findByIdOrFail(int $id): RoomRead;

    /**
     * @return array<array-key, mixed>
     */
    public function getAllPublicRoomsWithUsersCount(): array;

    /**
     * @return array<array-key, mixed>
     */
    public function getRoomDetails(int $roomId, int $userId): array;

    /**
     * @return array<array-key, mixed>
     */
    public function getUserQuestionsNotInRoom(int $authUserId, int $roomId): array;

    /**
     * @return array<array-key, mixed>
     */
    public function getUserPunishmentsNotInRoom(int $authUserId, int $roomId): array;
}
