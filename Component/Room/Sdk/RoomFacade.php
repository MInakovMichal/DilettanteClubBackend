<?php

namespace Component\Room\Sdk;

use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Model\RoomRead;

interface RoomFacade
{
    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead;

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract): void;

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract): void;

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void;

    /**
     * @param int $roomId
     * @return array<int,mixed>
     */
    public function getUsersInRoom(int $roomId): array;
}
