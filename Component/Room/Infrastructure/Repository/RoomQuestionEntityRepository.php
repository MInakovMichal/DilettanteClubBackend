<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomQuestion;

interface RoomQuestionEntityRepository
{
    public function addQuestionToRoom(int $roomId, int $questionId): void;

    public function deleteQuestionFromRoom(int $roomId, int $questionId): void;

    public function findByIdAndRoomIdOrFail(int $roomId, int $questionId): RoomQuestion;
}
