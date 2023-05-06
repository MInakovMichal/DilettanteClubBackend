<?php

namespace Component\Room\Sdk\Contract;

interface AddPunishmentsToRoomContract
{
    /**
     * @return array<int,int>
     */
    public function getPunishments(): array;

    public function getRoomId(): int;
}
