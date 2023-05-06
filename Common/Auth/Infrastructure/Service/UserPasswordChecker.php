<?php

namespace Common\Auth\Infrastructure\Service;

use Common\Auth\Sdk\Contract\LoginContract;

interface UserPasswordChecker
{
    public function check(LoginContract $contract): string;
}
