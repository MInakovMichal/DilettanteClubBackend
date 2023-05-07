<?php

namespace Component\Room\Infrastructure\Repository;

use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CloseRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Contract\UserLeaveRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomRepository
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead;

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract): void;

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract): void;

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void;

    /**
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array;

    public function deleteQuestionsFromRoom(int $roomId, int $questionId): void;

    public function deletePunishmentsFromRoom(int $roomId, int $punishmentId): void;

    public function userLeaveRoom(UserLeaveRoomContract $contract, int $authUserId): void;

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

    public function closeRoom(CloseRoomContract $contract, int $authUserId): void;

    public function findByIdOrFail(int $id): RoomRead;
}
