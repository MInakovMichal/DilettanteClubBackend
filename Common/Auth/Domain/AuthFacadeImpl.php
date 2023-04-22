<?php

namespace Common\Auth\Domain;

use Common\Auth\Sdk\AuthFacade;
use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\UserFacade;

class AuthFacadeImpl implements AuthFacade
{
    private UserFacade $userFacade;

    public function __construct(UserFacade $userFacade)
    {
        $this->userFacade = $userFacade;
    }

//    public function isLoggedIn(): bool
//    {
//        // TODO: Implement isLoggedIn() method.
//    }
//
//    public function current(): Authenticate
//    {
//        // TODO: Implement current() method.
//    }

//    public function authLogin(AuthContract $contract): Authenticate
//    {
//        // TODO: Implement authLogin() method.
//    }

    public function register(RegisterContract $contract): void
    {
        $this->userFacade->createUser($contract);
    }
}
