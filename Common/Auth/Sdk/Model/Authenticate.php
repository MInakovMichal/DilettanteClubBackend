<?php

declare(strict_types=1);

namespace Common\Auth\Sdk\Model;

final class Authenticate
{
    private string $token;
    private AuthUser $authUser;
    private int $ttl;

    public function __construct(string $token, AuthUser $authUser, int $ttl)
    {
        $this->token = $token;
        $this->authUser = $authUser;
        $this->ttl = $ttl;
    }

    public function getAuthUserId(): int
    {
        return $this->authUser->getId();
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getAuthUser(): AuthUser
    {
        return $this->authUser;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'id' => $this->authUser->getId(),
            'name' => $this->authUser->getName(),
            'email' => $this->authUser->getEmail(),
            'token' => $this->token,
            'ttl' => $this->ttl,
        ];
    }
}
