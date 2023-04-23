<?php

declare(strict_types=1);

namespace Common\ValueObject;

use Common\Exception\InvalidArgumentException;

final class Email
{
    private string $emailAddress;

    public function __construct(string $emailAddress)
    {
        $this->validate($emailAddress);
        $this->emailAddress = $emailAddress;
    }

    public function __toString(): string
    {
        return $this->emailAddress;
    }

    public function equals(self $object): bool
    {
        return strtolower($this->emailAddress) === strtolower($object->getEmailAddress());
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    private function validate(string $emailAddress): void
    {
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException("Invalid email signature");
        }
    }
}
