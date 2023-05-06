<?php

namespace Component\Room\Sdk\Contract;

interface AddQuestionsToRoomContract
{
    /**
     * @return array<int,int>
     */
    public function getQuestions(): array;

    public function getRoomId(): int;
}
