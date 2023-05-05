<?php

namespace Component\Room\Infrastructure\Http\Controller;

use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Sdk\Model\RoomRead;
use Component\Room\Sdk\RoomFacade;
use Illuminate\Http\JsonResponse;

class RoomController
{
    private RoomFacade $roomFacade;

    private AuthFacade $authFacade;

    /**
     * @param RoomFacade $roomFacade
     * @param AuthFacade $authFacade
     */
    public function __construct(RoomFacade $roomFacade, AuthFacade $authFacade)
    {
        $this->roomFacade = $roomFacade;
        $this->authFacade = $authFacade;
    }

    public function createRoom(CreateRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $room = $this->roomFacade->createRoom($request, $authUser->getAuthUserId());

        $message = 'Room was created successfully';

        return ApiResponse::successResponse($room->toArray(), $message);
    }
}
