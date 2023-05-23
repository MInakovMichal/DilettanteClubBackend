<?php

namespace Component\Room\Infrastructure\Http\Controller;

use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Component\Room\Infrastructure\Http\Requests\AddPunishmentsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\AddQuestionsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\CloseRoomRequest;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Infrastructure\Http\Requests\DeletePunishmentsFromRoomRequest;
use Component\Room\Infrastructure\Http\Requests\DeleteQuestionsFromRoomRequest;
use Component\Room\Infrastructure\Http\Requests\GetPublicRoomsRequest;
use Component\Room\Infrastructure\Http\Requests\RoomDetailsRequest;
use Component\Room\Infrastructure\Http\Requests\UserEnterRoomRequest;
use Component\Room\Infrastructure\Http\Requests\UserLeaveRoomRequest;
use Component\Room\Sdk\RoomFacade;
use Component\User\Sdk\UserFacade;
use Illuminate\Http\JsonResponse;

class RoomController
{
    private RoomFacade $roomFacade;

    private AuthFacade $authFacade;

    private UserFacade $userFacade;

    /**
     * @param RoomFacade $roomFacade
     * @param AuthFacade $authFacade
     * @param UserFacade $userFacade
     */
    public function __construct(
        RoomFacade $roomFacade,
        AuthFacade $authFacade,
        UserFacade $userFacade
    ) {
        $this->roomFacade = $roomFacade;
        $this->authFacade = $authFacade;
        $this->userFacade = $userFacade;
    }

    public function getAllPublicRooms(GetPublicRoomsRequest $request): JsonResponse
    {
        $publicRooms = $this->roomFacade->getAllPublicRoomsWithUsersCount();

        $message = 'All public rooms was loaded successfully';

        return ApiResponse::successResponse($publicRooms, $message);
    }

    public function getRoomDetails(RoomDetailsRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $publicRooms = $this->roomFacade->getRoomDetails($request, $authUser->getAuthUserId());

        $message = 'Rom details was loaded successfully';

        return ApiResponse::successResponse($publicRooms, $message);
    }

    public function createRoom(CreateRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $room = $this->roomFacade->createRoom($request, $authUser->getAuthUserId());
        $this->userFacade->addRoomToUser($authUser->getAuthUserId(), $room->getId());

        $questions = $this->roomFacade->getAllUserQuestionsInRoom($authUser->getAuthUserId(), $room->getId());
        $punishments = $this->roomFacade->getAllUserPunishmentsInRoom($authUser->getAuthUserId(), $room->getId());

        $usersInRoom = $this->roomFacade->getUsersInRoom($room->getId());

        $message = 'Room was created successfully';

        return ApiResponse::successResponse([
            'users' => $usersInRoom,
            'questions' => $questions,
            'punishments' => $punishments,
            'room' => $room->toArray()
        ], $message);
    }

    public function closeRoom(CloseRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->closeRoom($request, $authUser->getAuthUserId());

        $message = 'Room was closed successfully';

        return ApiResponse::successResponse([], $message);
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
        $this->userFacade->addRoomToUser($authUser->getAuthUserId(), $roomId);

        $room = $this->roomFacade->findByIdOrFail($roomId);
        $questions = $this->roomFacade->getAllUserQuestionsInRoom($authUser->getAuthUserId(), $roomId);
        $punishments = $this->roomFacade->getAllUserPunishmentsInRoom($authUser->getAuthUserId(), $roomId);

        $usersInRoom = $this->roomFacade->getUsersInRoom($roomId);

        $message = 'User has entered into the room successfully';

        return ApiResponse::successResponse([
            'users' => $usersInRoom,
            'questions' => $questions,
            'punishments' => $punishments,
            'room' => $room
        ], $message);
    }

    public function userLeaveRoom(UserLeaveRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->userLeaveRoom($request, $authUser->getAuthUserId());
        $this->userFacade->deleteRoomFromUser($authUser->getAuthUserId());

        $message = 'User has leave the room successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->deleteQuestionsFromRoom($request, $authUser->getAuthUserId());
        $message = 'Questions was deleted successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->deletePunishmentsFromRoom($request, $authUser->getAuthUserId());
        $message = 'Punishments was deleted successfully';

        return ApiResponse::successResponse([], $message);
    }
}
