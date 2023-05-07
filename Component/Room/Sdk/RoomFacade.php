<?php

namespace Component\Room\Sdk;

use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CloseRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\DeletePunishmentsFromRoomContract;
use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Contract\UserLeaveRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomFacade
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

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomContract $contract, int $authUserId): void;

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomContract $contract, int $authUserId): void;

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
