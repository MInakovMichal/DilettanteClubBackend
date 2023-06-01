<?php

namespace Component\Room\Infrastructure\Http\Controller;

use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Common\Http\BaseRequest;
use Component\Room\Infrastructure\Http\Requests\AddPunishmentsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\AddQuestionsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Infrastructure\Http\Requests\DeletePunishmentsFromRoomRequest;
use Component\Room\Infrastructure\Http\Requests\DeleteQuestionsFromRoomRequest;
use Component\Room\Infrastructure\Http\Requests\UserEnterRoomRequest;
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

    public function getAllPublicRooms(BaseRequest $request): JsonResponse
    {
        $publicRooms = $this->roomFacade->getAllPublicRoomsWithUsersCount();

        $message = 'All public rooms was loaded successfully';

        return ApiResponse::successResponse($publicRooms, $message);
    }

    public function getRoomDetails(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $publicRooms = $this->roomFacade->getRoomDetails($authUser->getRoomId(), $authUser->getAuthUserId());

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

    public function closeRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->userFacade->deleteRoomFromUser($authUser->getAuthUserId());
        $this->roomFacade->closeRoom($authUser->getRoomId(), $authUser->getAuthUserId());

        $message = 'Room was closed successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function addQuestionsToRoom(AddQuestionsToRoomRequest $request): JsonResponse
    {
        $roomId = $this->authFacade->current()->getRoomId();
        $this->roomFacade->addQuestionsToRoom($request, $roomId);
        $message = 'Questions was added successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function addPunishmentsToRoom(AddPunishmentsToRoomRequest $request): JsonResponse
    {
        $roomId = $this->authFacade->current()->getRoomId();
        $this->roomFacade->addPunishmentsToRoom($request, $roomId);
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

        $message = 'User has entered into the room successfully';

        return ApiResponse::successResponse($room, $message);
    }

    public function userLeaveRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->userLeaveRoom($authUser->getRoomId(), $authUser->getAuthUserId());
        $this->userFacade->deleteRoomFromUser($authUser->getAuthUserId());

        $message = 'User has leave the room successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->deleteQuestionsFromRoom($request, $authUser->getAuthUserId(), $authUser->getRoomId());
        $message = 'Questions was deleted successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $this->roomFacade->deletePunishmentsFromRoom($request, $authUser->getAuthUserId(), $authUser->getRoomId());
        $message = 'Punishments was deleted successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function getUserQuestionsNotInRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $questions = $this->roomFacade->getUserQuestionsNotInRoom($authUser->getAuthUserId(), $authUser->getRoomId());

        $message = 'Questions which not in room was loaded successfully';

        return ApiResponse::successResponse($questions, $message);
    }

    public function getUserPunishmentsNotInRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $punishments = $this->roomFacade->getUserPunishmentsNotInRoom($authUser->getAuthUserId(), $authUser->getRoomId());

        $message = 'Punishments which not in room was loaded successfully';

        return ApiResponse::successResponse($punishments, $message);
    }

    public function getUserQuestionsInRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $questions = $this->roomFacade->getAllUserQuestionsInRoom($authUser->getAuthUserId(), $authUser->getRoomId());

        $message = 'Questions which in room was loaded successfully';

        return ApiResponse::successResponse($questions, $message);
    }

    public function getUserPunishmentsInRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $punishments = $this->roomFacade->getAllUserPunishmentsInRoom($authUser->getAuthUserId(), $authUser->getRoomId());

        $message = 'Punishments which in room was loaded successfully';

        return ApiResponse::successResponse($punishments, $message);
    }

    public function getUsersInRoom(BaseRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();

        $users = $this->roomFacade->getUsersInRoom($authUser->getRoomId());

        $message = 'Users which in room was loaded successfully';

        return ApiResponse::successResponse($users, $message);
    }
}
