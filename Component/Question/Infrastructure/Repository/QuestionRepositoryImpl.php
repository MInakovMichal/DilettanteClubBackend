<?php

namespace Component\Question\Infrastructure\Repository;

use Component\Question\Infrastructure\Mapper\QuestionEntityMapper;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\DeleteQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Contract\UpdateQuestionContract;
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

    public function addQuestion(AddQuestionContract $contract, int $authUserId): QuestionRead
    {
        return $this->entityMapper->mapToReadModel($this->entityRepository->addQuestion($contract, $authUserId));
    }

    public function deleteQuestion(DeleteQuestionContract $contract, int $authUserId): void
    {
        $this->entityRepository->deleteQuestion($contract, $authUserId);
    }

    public function updateQuestion(UpdateQuestionContract $contract, int $authUserId): QuestionRead
    {
        return $this->entityMapper->mapToReadModel($this->entityRepository->updateQuestion($contract, $authUserId));
    }
}
