<?php

namespace Component\Room\Infrastructure\Repository;

use Component\Room\Infrastructure\Checker\RoomPasswordChecker;
use Component\Room\Infrastructure\Checker\RoomPunishmentAuthorChecker;
use Component\Room\Infrastructure\Checker\RoomQuestionAuthorChecker;
use Component\Room\Infrastructure\Mapper\RoomEntityMapper;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\DeletePunishmentsFromRoomContract;
use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Contract\UserLeaveRoomContract;
use Component\Room\Sdk\Model\RoomRead;

class RoomRepositoryImpl implements RoomRepository
{
    private RoomEntityRepository $repository;

    private RoomQuestionEntityRepository $roomQuestionRepository;

    private RoomPunishmentEntityRepository $roomPunishmentRepository;

    private RoomUserEntityRepository $roomUserRepository;

    private RoomEntityMapper $entityMapper;

    private RoomPasswordChecker $roomPasswordChecker;
    private RoomDatabaseRepository $databaseRepository;

    private RoomQuestionAuthorChecker $questionAuthorChecker;

    private RoomPunishmentAuthorChecker $punishmentAuthorChecker;

    /**
     * @param RoomEntityRepository $repository
     * @param RoomEntityMapper $entityMapper
     * @param RoomQuestionEntityRepository $roomQuestionRepository
     * @param RoomPunishmentEntityRepository $roomPunishmentRepository
     * @param RoomUserEntityRepository $roomUserRepository
     * @param RoomPasswordChecker $roomPasswordChecker
     * @param RoomDatabaseRepository $databaseRepository
     * @param RoomQuestionAuthorChecker $questionAuthorChecker
     * @param RoomPunishmentAuthorChecker $punishmentAuthorChecker
     */
    public function __construct(
        RoomEntityRepository $repository,
        RoomEntityMapper $entityMapper,
        RoomQuestionEntityRepository $roomQuestionRepository,
        RoomPunishmentEntityRepository $roomPunishmentRepository,
        RoomUserEntityRepository $roomUserRepository,
        RoomPasswordChecker $roomPasswordChecker,
        RoomDatabaseRepository $databaseRepository,
        RoomQuestionAuthorChecker $questionAuthorChecker,
        RoomPunishmentAuthorChecker $punishmentAuthorChecker,
    ) {
        $this->repository = $repository;
        $this->entityMapper = $entityMapper;
        $this->roomQuestionRepository = $roomQuestionRepository;
        $this->roomPunishmentRepository = $roomPunishmentRepository;
        $this->roomUserRepository = $roomUserRepository;
        $this->roomPasswordChecker = $roomPasswordChecker;
        $this->databaseRepository = $databaseRepository;
        $this->questionAuthorChecker = $questionAuthorChecker;
        $this->punishmentAuthorChecker = $punishmentAuthorChecker;
    }


    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        $room = $this->entityMapper->mapToReadModel($this->repository->createRoom($contract, $authUserId));
        $this->roomUserRepository->userEnterRoom($room->getId(), $authUserId);

        return $room;
    }

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void
    {
        $this->roomPasswordChecker->check($contract);

        $this->roomUserRepository->userEnterRoom($contract->getRoomId(), $authUserId);
    }

    public function addQuestionsToRoom(AddQuestionsToRoomContract $contract): void
    {
        $roomId = $contract->getRoomId();
        $questionsId = $contract->getQuestions();

        foreach ($questionsId as $questionId) {
            $this->roomQuestionRepository->addQuestionToRoom($roomId, $questionId);
        }
    }

    public function addPunishmentsToRoom(AddPunishmentsToRoomContract $contract): void
    {
        $roomId = $contract->getRoomId();
        $punishmentsId = $contract->getPunishments();

        foreach ($punishmentsId as $punishmentId) {
            $this->roomPunishmentRepository->addPunishmentToRoom($roomId, $punishmentId);
        }
    }

    /**
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->databaseRepository->getUsersInRoom($roomId);
    }

    public function deleteQuestionsFromRoom(DeleteQuestionsFromRoomContract $contract, int $authUserId): void
    {
        $roomId = $contract->getRoomId();
        $questionsId = $contract->getQuestions();
        foreach ($questionsId as $questionId) {
            $this->questionAuthorChecker->check($questionId, $authUserId);

            $this->roomQuestionRepository->deleteQuestionFromRoom($roomId, $questionId);
        }
    }

    public function deletePunishmentsFromRoom(DeletePunishmentsFromRoomContract $contract, int $authUserId): void
    {
        $roomId = $contract->getRoomId();
        $punishmentsId = $contract->getPunishments();
        foreach ($punishmentsId as $punishmentId) {
            $this->punishmentAuthorChecker->check($punishmentId, $authUserId);

            $this->roomPunishmentRepository->deletePunishmentFromRoom($roomId, $punishmentId);
        }
    }

    public function userLeaveRoom(UserLeaveRoomContract $contract, int $authUserId): void
    {
        $this->roomUserRepository->userLeaveRoom($contract->getRoomId(), $authUserId);
    }
}
