<?php

namespace Common\Auth\Infrastructure\Service;

use Common\Auth\Infrastructure\Http\Requests\LoginRequest;
use Common\Auth\Sdk\Contract\LoginContract;
use Common\Exception\UserWithProvidedCredentialsNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserPasswordCheckerImpl implements UserPasswordChecker
{
    public function check(LoginContract $contract): string
    {
        /** @var string $token */
        $token = JWTAuth::attempt(['email' => $contract->getEmail()->getEmailAddress(), 'password' => $contract->getPassword()]);/** @phpstan-ignore-line */

        if (!$token) {
            throw new UserWithProvidedCredentialsNotFoundException();
        }

        return $token;
    }
}
