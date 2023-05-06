<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomQuestion;
use Throwable;
use UnexpectedValueException;

class RoomQuestionEntityRepositoryImpl implements RoomQuestionEntityRepository
{
    public function addQuestionToRoom(int $roomId, int $questionId): void
    {
        try {
            $roomQuestion = new RoomQuestion();
            $roomQuestion->setRoomId($roomId);
            $roomQuestion->setQuestionId($questionId);
            $roomQuestion->setInGame(false);
            $roomQuestion->setIsUsed(false);
            $roomQuestion->save();
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }
}
