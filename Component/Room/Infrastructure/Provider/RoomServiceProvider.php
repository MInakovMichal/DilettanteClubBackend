<?php

declare(strict_types=1);

namespace Component\Room\Infrastructure\Provider;

use Component\Room\Domain\RoomFacadeImpl;
use Component\Room\Infrastructure\Checker\RoomPasswordChecker;
use Component\Room\Infrastructure\Checker\RoomPasswordCheckerImpl;
use Component\Room\Infrastructure\Checker\RoomQuestionAuthorChecker;
use Component\Room\Infrastructure\Checker\RoomQuestionAuthorCheckerImpl;
use Component\Room\Infrastructure\Repository\RoomDatabaseRepository;
use Component\Room\Infrastructure\Repository\RoomDatabaseRepositoryImpl;
use Component\Room\Infrastructure\Repository\RoomEntityRepository;
use Component\Room\Infrastructure\Repository\RoomEntityRepositoryImpl;
use Component\Room\Infrastructure\Repository\RoomPunishmentEntityRepository;
use Component\Room\Infrastructure\Repository\RoomPunishmentEntityRepositoryImpl;
use Component\Room\Infrastructure\Repository\RoomQuestionEntityRepository;
use Component\Room\Infrastructure\Repository\RoomQuestionEntityRepositoryImpl;
use Component\Room\Infrastructure\Repository\RoomRepository;
use Component\Room\Infrastructure\Repository\RoomRepositoryImpl;
use Component\Room\Infrastructure\Repository\RoomUserEntityRepository;
use Component\Room\Infrastructure\Repository\RoomUserEntityRepositoryImpl;
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
        $this->app->bind(RoomQuestionEntityRepository::class, RoomQuestionEntityRepositoryImpl::class);
        $this->app->bind(RoomPunishmentEntityRepository::class, RoomPunishmentEntityRepositoryImpl::class);
        $this->app->bind(RoomUserEntityRepository::class, RoomUserEntityRepositoryImpl::class);
        $this->app->bind(RoomPasswordChecker::class, RoomPasswordCheckerImpl::class);
        $this->app->bind(RoomDatabaseRepository::class, RoomDatabaseRepositoryImpl::class);
        $this->app->bind(RoomQuestionAuthorChecker::class, RoomQuestionAuthorCheckerImpl::class);
    }
}
