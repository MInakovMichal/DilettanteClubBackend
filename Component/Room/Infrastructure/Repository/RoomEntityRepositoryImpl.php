<?php

namespace Component\Room\Infrastructure\Repository;

use App\Models\Room;
use Common\Exception\RoomByIdNotFoundException;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Throwable;
use UnexpectedValueException;

class RoomEntityRepositoryImpl implements RoomEntityRepository
{
    private Room $entity;

    /**
     * @param Room $entity
     */
    public function __construct(Room $entity)
    {
        $this->entity = $entity;
    }

    public function createRoom(CreateRoomContract $contract, int $authUserId): Room
    {
        try {
            $isPrivate = $contract->isPrivate();

            $room = new Room();
            $room->setLanguageId($contract->getLanguageId());
            $room->setName($contract->getName());
            $room->setAuthorId($authUserId);
            $room->setIsPrivate($isPrivate);
            if ($isPrivate) {
                $password = Hash::make($contract->getPassword());
                $room->setPassword($password);
            }
            $room->save();

            return $room;
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }


    public function findByIdOrFail(int $id): Room
    {
        try {
            /** @var Room $room */
            $room = $this->entity->findOrFail($id);
            return $room;
        } catch (ModelNotFoundException $e) {
            throw new RoomByIdNotFoundException($id);
        }
    }
}
