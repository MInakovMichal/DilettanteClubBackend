<?php

namespace Common\Auth\Sdk;

use Common\Auth\Sdk\Contract\AuthContract;
use Common\Auth\Sdk\Contract\RegisterContract;
use Common\Auth\Sdk\Model\Authenticate;
use Common\Auth\Sdk\Model\AuthUser;

interface AuthFacade
{
//    public function isLoggedIn(): bool;
//
//    public function current(): Authenticate;

//    public function authLogin(AuthContract $contract): Authenticate;

    public function register(RegisterContract $contract): void;
}
