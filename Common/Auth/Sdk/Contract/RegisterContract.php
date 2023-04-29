<?php

namespace Common\Auth\Sdk\Contract;

use Common\ValueObject\Email;

interface RegisterContract
{
    public function getName(): string;

    public function getUsername(): string;

    public function getEmail(): Email;

    public function getPassword(): string;

    public function getLanguageId(): int;
}
