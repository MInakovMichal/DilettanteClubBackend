<?php

declare(strict_types=1);

namespace Component\Question\Infrastructure\Provider;

use Component\Question\Domain\QuestionFacadeImpl;
use Component\Question\Infrastructure\Repository\QuestionEntityRepository;
use Component\Question\Infrastructure\Repository\QuestionEntityRepositoryImpl;
use Component\Question\Infrastructure\Repository\QuestionRepository;
use Component\Question\Infrastructure\Repository\QuestionRepositoryImpl;
use Component\Question\Infrastructure\Service\QuestionService;
use Component\Question\Infrastructure\Service\QuestionServiceImpl;
use Component\Question\Sdk\QuestionFacade;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class QuestionServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(QuestionFacade::class, QuestionFacadeImpl::class);
        $this->app->bind(QuestionService::class, QuestionServiceImpl::class);
        $this->app->bind(QuestionRepository::class, QuestionRepositoryImpl::class);
        $this->app->bind(QuestionEntityRepository::class, QuestionEntityRepositoryImpl::class);
    }
}
