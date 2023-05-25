<?php

namespace Component\Room\Sdk\Contract;

interface DeletePunishmentsFromRoomContract
{
    /**
     * @return array<int,int>
     */
    public function getPunishments(): array;
}
