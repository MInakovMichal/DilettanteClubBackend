<?php

namespace Common\Auth\Sdk\Contract;

interface RegisterContract
{
    public function getName(): string;

    public function getUsername(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getLanguageId(): int;
}
