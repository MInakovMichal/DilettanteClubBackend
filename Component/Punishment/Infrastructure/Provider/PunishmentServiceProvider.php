<?php

declare(strict_types=1);

namespace Component\Punishment\Infrastructure\Provider;

use Component\Punishment\Domain\PunishmentFacadeImpl;
use Component\Punishment\Infrastructure\Repository\PunishmentEntityRepository;
use Component\Punishment\Infrastructure\Repository\PunishmentEntityRepositoryImpl;
use Component\Punishment\Infrastructure\Repository\PunishmentRepository;
use Component\Punishment\Infrastructure\Repository\PunishmentRepositoryImpl;
use Component\Punishment\Infrastructure\Service\PunishmentService;
use Component\Punishment\Infrastructure\Service\PunishmentServiceImpl;
use Component\Punishment\Sdk\PunishmentFacade;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class PunishmentServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(PunishmentFacade::class, PunishmentFacadeImpl::class);
        $this->app->bind(PunishmentService::class, PunishmentServiceImpl::class);
        $this->app->bind(PunishmentRepository::class, PunishmentRepositoryImpl::class);
        $this->app->bind(PunishmentEntityRepository::class, PunishmentEntityRepositoryImpl::class);
    }
}
