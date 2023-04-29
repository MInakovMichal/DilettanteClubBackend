<?php

namespace Common\Auth\Sdk;

use Common\Auth\Sdk\Contract\LoginContract;
use Common\Auth\Sdk\Contract\RegisterContract;
use Common\Auth\Sdk\Model\Authenticate;
use Component\User\Sdk\Model\UserRead;

interface AuthFacade
{
    public function isLoggedIn(): bool;

    public function current(): Authenticate;

    public function login(LoginContract $contract): Authenticate;

    public function register(RegisterContract $contract): UserRead;
}
