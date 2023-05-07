<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\RoomUser;
use Common\Exception\RoomUserByIdNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use UnexpectedValueException;

class RoomUserEntityRepositoryImpl implements RoomUserEntityRepository
{
    private RoomUser $entity;

    /**
     * @param RoomUser $entity
     */
    public function __construct(RoomUser $entity)
    {
        $this->entity = $entity;
    }

    public function userEnterRoom(int $roomId, int $authUserId): void
    {
        try {
            $roomUser = new RoomUser();
            $roomUser->setUserId($authUserId);
            $roomUser->setRoomId($roomId);
            $roomUser->setIsReady(false);
            $roomUser->setWins(0);
            $roomUser->setLooses(0);
            $roomUser->save();
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }

    public function userLeaveRoom(int $roomId, int $authUserId): void
    {
        $roomUser = self::findByUserIdAndRoomId($roomId, $authUserId);
        $roomUser->delete();
    }

    public function findByUserIdAndRoomId(int $roomId, int $authUserId): RoomUser
    {
        try {
            /** @var RoomUser $roomUser */
            $roomUser = $this->entity->where('room_id', $roomId)->where('user_id', $authUserId)->firstOrFail();
            return $roomUser;
        } catch (ModelNotFoundException $e) {
            throw new RoomUserByIdNotFoundException($roomId, $authUserId);
        }
    }
}
