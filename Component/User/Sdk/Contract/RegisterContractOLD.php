<?php

namespace Component\User\Sdk\Contract;

interface RegisterContractOLD
{
    public function getName(): string;

    public function getUsername(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getLanguageId(): int;
}
