<?php

declare(strict_types=1);

namespace Component\Question\Infrastructure\Mapper;

use App\Models\Question;
use Component\Question\Sdk\Model\QuestionRead;

final class QuestionEntityMapper
{
    public function mapToReadModel(Question $questionEntity): QuestionRead
    {
        return new QuestionRead(
            $questionEntity->getId(),
            $questionEntity->getQuestion(),
            $questionEntity->getAnswer(),
            $questionEntity->getUseCount(),
            $questionEntity->getLanguageId()
        );
    }
}
