<?php

declare(strict_types=1);

namespace Common\Auth\Infrastructure\Provider;

use Common\Auth\Domain\AuthFacadeImpl;
use Common\Auth\Domain\UserProvider\UserProvider;
use Common\Auth\Infrastructure\Service\SocialiteService;
use Common\Auth\Infrastructure\Service\SocialiteServiceImpl;
use Common\Auth\Infrastructure\Service\UserPasswordChecker;
use Common\Auth\Infrastructure\Service\UserPasswordCheckerImpl;
use Common\Auth\Infrastructure\UserProvider\UserProviderImpl;
use Common\Auth\Sdk\AuthFacade;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class AuthServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(AuthFacade::class, AuthFacadeImpl::class);
        $this->app->bind(SocialiteService::class, SocialiteServiceImpl::class);
        $this->app->bind(UserProvider::class, UserProviderImpl::class);
        $this->app->bind(UserPasswordChecker::class, UserPasswordCheckerImpl::class);
    }
}
