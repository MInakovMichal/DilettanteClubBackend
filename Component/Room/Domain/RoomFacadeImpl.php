<?php

namespace Component\Room\Domain;

use Component\Room\Infrastructure\Service\RoomService;
use Component\Room\Sdk\Contract\CreateRoomContract;
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
}
