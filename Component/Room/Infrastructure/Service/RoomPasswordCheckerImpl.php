<?php

namespace Component\Room\Infrastructure\Service;

use Common\Exception\PasswordNotMatchException;
use Component\Room\Infrastructure\Repository\RoomEntityRepository;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Illuminate\Support\Facades\Hash;

class RoomPasswordCheckerImpl implements RoomPasswordChecker
{
    private RoomEntityRepository $repository;

    /**
     * @param RoomEntityRepository $repository
     */
    public function __construct(RoomEntityRepository $repository)
    {
        $this->repository = $repository;
    }


    public function check(UserEnterRoomContract $contract): void
    {
        $room = $this->repository->findByIdOrFail($contract->getRoomId());

        if ($room->isPrivate() && !Hash::check($contract->getPassword(), $room->getPassword())) {
            throw new PasswordNotMatchException();
        }
    }
}
