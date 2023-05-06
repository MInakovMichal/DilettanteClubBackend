<?php

namespace Component\Room\Infrastructure\Checker;

use Component\Room\Sdk\Contract\UserEnterRoomContract;

interface RoomQuestionAuthorChecker
{
    public function check(int $questionId, int $userId): void;
}
