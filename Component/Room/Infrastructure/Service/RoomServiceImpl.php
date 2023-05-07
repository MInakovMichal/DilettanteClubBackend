<?php

namespace Component\Room\Infrastructure\Service;

use Component\Room\Infrastructure\Checker\RoomAuthorChecker;
use Component\Room\Infrastructure\Checker\RoomPasswordChecker;
use Component\Room\Infrastructure\Checker\RoomPunishmentAuthorChecker;
use Component\Room\Infrastructure\Checker\RoomQuestionAuthorChecker;
use Component\Room\Infrastructure\Repository\RoomRepository;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CloseRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\DeletePunishmentsFromRoomContract;
use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Contract\UserLeaveRoomContract;
use Component\Room\Sdk\Model\RoomRead;

class RoomServiceImpl implements RoomService
{
    private RoomRepository $repository;

    private RoomAuthorChecker $roomAuthorChecker;

    private RoomPasswordChecker $roomPasswordChecker;

    private RoomPunishmentAuthorChecker $punishmentAuthorChecker;

    private RoomQuestionAuthorChecker $questionAuthorChecker;

    /**
     * @param RoomRepository $repository
     * @param RoomAuthorChecker $roomAuthorChecker
     * @param RoomPasswordChecker $roomPasswordChecker
     * @param RoomPunishmentAuthorChecker $punishmentAuthorChecker
     * @param RoomQuestionAuthorChecker $questionAuthorChecker
     */
    public function __construct(
        RoomRepository $repository,
        RoomAuthorChecker $roomAuthorChecker,
        RoomPasswordChecker $roomPasswordChecker,
        RoomPunishmentAuthorChecker $punishmentAuthorChecker,
        RoomQuestionAuthorChecker $questionAuthorChecker
    ) {
        $this->repository = $repository;
        $this->roomAuthorChecker = $roomAuthorChecker;
        $this->roomPasswordChecker = $roomPasswordChecker;
        $this->punishmentAuthorChecker = $punishmentAuthorChecker;
        $this->questionAuthorChecker = $questionAuthorChecker;
    }


    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        return $this->repository->createRoom($contract, $authUserId);
    }

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract): void
    {
        $this->repository->addQuestionsToRoom($contract);
    }

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract): void
    {
        $this->repository->addPunishmentsToRoom($contract);
    }

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void
    {
        $this->roomPasswordChecker->check($contract);

        $this->repository->userEnterRoom($contract, $authUserId);
    }

    /**
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->repository->getUsersInRoom($roomId);
    }

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomContract $contract, int $authUserId): void
    {
        $roomId = $contract->getRoomId();
        $questionsId = $contract->getQuestions();
        foreach ($questionsId as $questionId) {
            $this->questionAuthorChecker->check($questionId, $authUserId);

            $this->repository->deleteQuestionsFromRoom($roomId, $questionId);
        }
    }

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomContract $contract, int $authUserId): void
    {
        $roomId = $contract->getRoomId();
        $punishmentsId = $contract->getPunishments();
        foreach ($punishmentsId as $punishmentId) {
            $this->punishmentAuthorChecker->check($punishmentId, $authUserId);

            $this->repository->deletePunishmentsFromRoom($roomId, $punishmentId);
        }
    }

    public function userLeaveRoom(UserLeaveRoomContract $contract, int $authUserId): void
    {
        $this->repository->userLeaveRoom($contract, $authUserId);
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserQuestionsInRoom(int $authUserId, int $roomId): array
    {
        return $this->repository->getAllUserQuestionsInRoom($authUserId, $roomId);
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserPunishmentsInRoom(int $authUserId, int $roomId): array
    {
        return $this->repository->getAllUserPunishmentsInRoom($authUserId, $roomId);
    }

    public function closeRoom(CloseRoomContract $contract, int $authUserId): void
    {
        $this->roomAuthorChecker->check($contract, $authUserId);

        $this->repository->closeRoom($contract, $authUserId);
    }

    public function findByIdOrFail(int $id): RoomRead
    {
        return $this->repository->findByIdOrFail($id);
    }
}
