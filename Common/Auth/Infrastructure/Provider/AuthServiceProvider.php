<?php

declare(strict_types=1);

namespace Common\Auth\Infrastructure\Provider;

use Common\Auth\Domain\AuthFacadeImpl;
use Common\Auth\Sdk\AuthFacade;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class AuthServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(AuthFacade::class, AuthFacadeImpl::class);
    }
}
