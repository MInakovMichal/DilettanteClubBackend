<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomPunishment;
use Common\Exception\RoomPunishmentByIdNotFoundException;
use Common\Exception\RoomQuestionByIdNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use UnexpectedValueException;

class RoomPunishmentEntityRepositoryImpl implements RoomPunishmentEntityRepository
{
    private RoomPunishment $entity;

    /**
     * @param RoomPunishment $entity
     */
    public function __construct(RoomPunishment $entity)
    {
        $this->entity = $entity;
    }

    public function addPunishmentToRoom(int $roomId, int $punishmentId): void
    {
        try {
            $roomPunishment = new RoomPunishment();
            $roomPunishment->setRoomId($roomId);
            $roomPunishment->setPunishmentId($punishmentId);
            $roomPunishment->setInGame(false);
            $roomPunishment->setIsUsed(false);
            $roomPunishment->save();
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }

    public function deletePunishmentFromRoom(int $roomId, int $punishmentId): void
    {
        self::findByIdAndRoomIdOrFail($roomId, $punishmentId)->delete();
    }

    public function findByIdAndRoomIdOrFail(int $roomId, int $punishmentId): RoomPunishment
    {
        try {
            /** @var RoomPunishment $roomPunishment */
            $roomPunishment = $this->entity->where('room_id', $roomId)->where('punishment_id', $punishmentId)->firstOrFail();
            return $roomPunishment;
        } catch (ModelNotFoundException $e) {
            throw new RoomPunishmentByIdNotFoundException($punishmentId, $roomId);
        }
    }
}
