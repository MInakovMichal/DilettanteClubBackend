<?php

namespace Component\Question\Infrastructure\Repository;

use Component\Question\Infrastructure\Mapper\QuestionEntityMapper;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Model\QuestionRead;
use Illuminate\Support\Collection;

class QuestionRepositoryImpl implements QuestionRepository
{
    private QuestionEntityRepository $entityRepository;

    private QuestionEntityMapper $entityMapper;

    public function __construct(QuestionEntityRepository $entityRepository, QuestionEntityMapper $entityMapper)
    {
        $this->entityRepository = $entityRepository;
        $this->entityMapper = $entityMapper;
    }

    public function getAllQuestions(GetQuestionsContract $contract): Collection
    {
        return $this->entityRepository->getAllQuestions($contract);
    }

    public function addQuestion(AddQuestionContract $contract): QuestionRead
    {
        return $this->entityMapper->mapToReadModel($this->entityRepository->addQuestion($contract));
    }
}
