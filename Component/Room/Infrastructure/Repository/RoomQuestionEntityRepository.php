<?php

namespace Component\Room\Infrastructure\Repository;

interface RoomQuestionEntityRepository
{
    public function addQuestionToRoom(int $roomId, int $questionId): void;
}
