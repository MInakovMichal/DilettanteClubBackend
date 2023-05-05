<?php

declare(strict_types=1);

namespace Component\Room\Infrastructure\Provider;

use Component\Room\Domain\RoomFacadeImpl;
use Component\Room\Infrastructure\Repository\RoomEntityRepository;
use Component\Room\Infrastructure\Repository\RoomEntityRepositoryImpl;
use Component\Room\Infrastructure\Repository\RoomRepository;
use Component\Room\Infrastructure\Repository\RoomRepositoryImpl;
use Component\Room\Infrastructure\Service\RoomService;
use Component\Room\Infrastructure\Service\RoomServiceImpl;
use Component\Room\Sdk\RoomFacade;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class RoomServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(RoomFacade::class, RoomFacadeImpl::class);
        $this->app->bind(RoomService::class, RoomServiceImpl::class);
        $this->app->bind(RoomRepository::class, RoomRepositoryImpl::class);
        $this->app->bind(RoomEntityRepository::class, RoomEntityRepositoryImpl::class);
    }
}
