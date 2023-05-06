<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomQuestion;
use Common\Exception\RoomQuestionByIdNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use UnexpectedValueException;

class RoomQuestionEntityRepositoryImpl implements RoomQuestionEntityRepository
{
    private RoomQuestion $entity;

    /**
     * @param RoomQuestion $entity
     */
    public function __construct(RoomQuestion $entity)
    {
        $this->entity = $entity;
    }

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

    public function deleteQuestionFromRoom(int $roomId, int $questionId): void
    {
        self::findByIdAndRoomIdOrFail($roomId, $questionId)->delete();
    }

    public function findByIdAndRoomIdOrFail(int $roomId, int $questionId): RoomQuestion
    {
        try {
            /** @var RoomQuestion $roomQuestion */
            $roomQuestion = $this->entity->where('room_id', $roomId)->where('question_id', $questionId)->firstOrFail();
            return $roomQuestion;
        } catch (ModelNotFoundException $e) {
            throw new RoomQuestionByIdNotFoundException($questionId, $roomId);
        }
    }
}
