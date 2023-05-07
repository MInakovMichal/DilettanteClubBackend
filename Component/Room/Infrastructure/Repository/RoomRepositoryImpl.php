<?php

namespace Component\Room\Infrastructure\Repository;

use Component\Room\Infrastructure\Mapper\RoomEntityMapper;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CloseRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
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

    private RoomDatabaseRepository $databaseRepository;

    /**
     * @param RoomEntityRepository $repository
     * @param RoomEntityMapper $entityMapper
     * @param RoomQuestionEntityRepository $roomQuestionRepository
     * @param RoomPunishmentEntityRepository $roomPunishmentRepository
     * @param RoomUserEntityRepository $roomUserRepository
     * @param RoomDatabaseRepository $databaseRepository
     */
    public function __construct(
        RoomEntityRepository $repository,
        RoomEntityMapper $entityMapper,
        RoomQuestionEntityRepository $roomQuestionRepository,
        RoomPunishmentEntityRepository $roomPunishmentRepository,
        RoomUserEntityRepository $roomUserRepository,
        RoomDatabaseRepository $databaseRepository,
    ) {
        $this->repository = $repository;
        $this->entityMapper = $entityMapper;
        $this->roomQuestionRepository = $roomQuestionRepository;
        $this->roomPunishmentRepository = $roomPunishmentRepository;
        $this->roomUserRepository = $roomUserRepository;
        $this->databaseRepository = $databaseRepository;
    }


    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        $room = $this->entityMapper->mapToReadModel($this->repository->createRoom($contract, $authUserId));
        $this->roomUserRepository->userEnterRoom($room->getId(), $authUserId);

        return $room;
    }

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void
    {
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

    public function deleteQuestionsFromRoom(int $roomId, int $questionId): void
    {
        $this->roomQuestionRepository->deleteQuestionFromRoom($roomId, $questionId);
    }

    public function deletePunishmentsFromRoom(int $roomId, int $punishmentId): void
    {
        $this->roomPunishmentRepository->deletePunishmentFromRoom($roomId, $punishmentId);
    }

    public function userLeaveRoom(UserLeaveRoomContract $contract, int $authUserId): void
    {
        $this->roomUserRepository->userLeaveRoom($contract->getRoomId(), $authUserId);
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserQuestionsInRoom(int $authUserId, int $roomId): array
    {
        return $this->databaseRepository->getAllUserQuestionsInRoom($authUserId, $roomId);
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserPunishmentsInRoom(int $authUserId, int $roomId): array
    {
        return $this->databaseRepository->getAllUserPunishmentsInRoom($authUserId, $roomId);
    }

    public function closeRoom(CloseRoomContract $contract, int $authUserId): void
    {
        $this->repository->closeRoom($contract, $authUserId);
    }

    public function findByIdOrFail(int $id): RoomRead
    {
        return $this->entityMapper->mapToReadModel($this->repository->findByIdOrFail($id));
    }
}
