<?php

namespace Component\Room\Sdk\Contract;

interface DeleteQuestionsFromRoomContract
{
    /**
     * @return array<int,int>
     */
    public function getQuestions(): array;
}
