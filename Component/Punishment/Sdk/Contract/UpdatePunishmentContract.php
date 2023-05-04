<?php

namespace Component\Punishment\Sdk\Contract;

interface UpdatePunishmentContract
{
    public function getPunishmentId(): int;

    public function getPunishment(): string;

    public function getLanguageId(): int;
}
