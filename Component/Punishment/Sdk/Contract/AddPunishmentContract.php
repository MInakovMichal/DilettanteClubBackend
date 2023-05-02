<?php

namespace Component\Punishment\Sdk\Contract;

interface AddPunishmentContract
{
    public function getUserId(): int;
    public function getPunishment(): string;
    public function getLanguageId(): int;
}
