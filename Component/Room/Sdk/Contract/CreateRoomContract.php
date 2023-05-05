<?php

namespace Component\Room\Sdk\Contract;

interface CreateRoomContract
{
    public function getName(): string;

    public function getLanguageId(): int;

    public function isPrivate(): bool;

    public function getPassword(): string;
}
