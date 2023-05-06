<?php

namespace Component\Room\Infrastructure\Http\Controller;

use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Component\Room\Infrastructure\Http\Requests\AddPunishmentsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\AddQuestionsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Infrastructure\Http\Requests\UserEnterRoomRequest;
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

        $usersInRoom = $this->roomFacade->getUsersInRoom($room->getId());

        $message = 'Room was created successfully';

        return ApiResponse::successResponse([
            'users' => $usersInRoom,
            'room' => $room->toArray()
        ], $message);
    }

    public function addQuestionsToRoom(AddQuestionsToRoomRequest $request): JsonResponse
    {
        $this->roomFacade->addQuestionsToRoom($request);
        $message = 'Questions was added successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function addPunishmentsToRoom(AddPunishmentsToRoomRequest $request): JsonResponse
    {
        $this->roomFacade->addPunishmentsToRoom($request);
        $message = 'Punishments was added successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function userEnterRoom(UserEnterRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $roomId = $request->getRoomId();

        $this->roomFacade->userEnterRoom($request, $authUser->getAuthUserId());

        $usersInRoom = $this->roomFacade->getUsersInRoom($roomId);

        $message = 'User has entered into the room successfully';

        return ApiResponse::successResponse([
            'users' => $usersInRoom
        ], $message);
    }
}
