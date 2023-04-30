<?php

declare(strict_types=1);

namespace Common\Auth\Sdk\Model;

final class Authenticate
{
    private string $token;
    private AuthUser $authUser;

    public function __construct(string $token, AuthUser $authUser)
    {
        $this->token = $token;
        $this->authUser = $authUser;
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

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->authUser->getId(),
            'name' => $this->authUser->getName(),
            'email' => $this->authUser->getEmail(),
            'token' => $this->token,
        ];
    }
}
