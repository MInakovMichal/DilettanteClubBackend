<?php

declare(strict_types=1);

namespace Component\User\Infrastructure\Provider;

use Component\User\Domain\UserFacadeImpl;
use Component\User\Infrastructure\Repository\UserEntityRepository;
use Component\User\Infrastructure\Repository\UserEntityRepositoryImpl;
use Component\User\Infrastructure\Repository\UserRepository;
use Component\User\Infrastructure\Repository\UserRepositoryImpl;
use Component\User\Infrastructure\Service\UserService;
use Component\User\Infrastructure\Service\UserServiceImpl;
use Component\User\Sdk\UserFacade;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class UserServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(UserFacade::class, UserFacadeImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(UserEntityRepository::class, UserEntityRepositoryImpl::class);
    }
}
