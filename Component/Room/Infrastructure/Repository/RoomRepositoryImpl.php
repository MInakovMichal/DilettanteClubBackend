<?php

namespace Component\Room\Infrastructure\Repository;

use Component\Room\Infrastructure\Mapper\RoomEntityMapper;
use Component\Room\Infrastructure\Service\RoomPasswordChecker;
use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Component\Room\Sdk\Model\RoomRead;

class RoomRepositoryImpl implements RoomRepository
{
    private RoomEntityRepository $repository;

    private RoomQuestionEntityRepository $roomQuestionRepository;

    private RoomPunishmentEntityRepository $roomPunishmentRepository;

    private RoomUserEntityRepository $roomUserRepository;

    private RoomEntityMapper $entityMapper;

    private RoomPasswordChecker $checker;
    private RoomDatabaseRepository $databaseRepository;

    /**
     * @param RoomEntityRepository $repository
     * @param RoomEntityMapper $entityMapper
     * @param RoomQuestionEntityRepository $roomQuestionRepository
     * @param RoomPunishmentEntityRepository $roomPunishmentRepository
     * @param RoomUserEntityRepository $roomUserRepository
     * @param RoomPasswordChecker $checker
     * @param RoomDatabaseRepository $databaseRepository
     */
    public function __construct(
        RoomEntityRepository $repository,
        RoomEntityMapper $entityMapper,
        RoomQuestionEntityRepository $roomQuestionRepository,
        RoomPunishmentEntityRepository $roomPunishmentRepository,
        RoomUserEntityRepository $roomUserRepository,
        RoomPasswordChecker $checker,
        RoomDatabaseRepository $databaseRepository
    ) {
        $this->repository = $repository;
        $this->entityMapper = $entityMapper;
        $this->roomQuestionRepository = $roomQuestionRepository;
        $this->roomPunishmentRepository = $roomPunishmentRepository;
        $this->roomUserRepository = $roomUserRepository;
        $this->checker = $checker;
        $this->databaseRepository = $databaseRepository;
    }


    public function createRoom(CreateRoomContract $contract, int $authUserId): RoomRead
    {
        return $this->entityMapper->mapToReadModel($this->repository->createRoom($contract, $authUserId));
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

    public function userEnterRoom(UserEnterRoomContract $contract, int $authUserId): void
    {
        $this->checker->check($contract);

        $this->roomUserRepository->userEnterRoom($contract->getRoomId(), $authUserId);
    }

    /**
     * @param int $roomId
     * @return array<int,mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->databaseRepository->getUsersInRoom($roomId);
    }
}
