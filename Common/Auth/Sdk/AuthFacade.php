<?php

namespace Common\Auth\Sdk;

use Common\Auth\Sdk\Contract\RegisterContract;

interface AuthFacade
{
//    public function isLoggedIn(): bool;
//
//    public function current(): Authenticate;

//    public function authLogin(AuthContract $contract): Authenticate;

    public function register(RegisterContract $contract): void;
}
