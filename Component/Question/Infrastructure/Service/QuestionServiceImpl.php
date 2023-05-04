<?php

namespace Component\Question\Infrastructure\Service;

use Component\Question\Infrastructure\Repository\QuestionRepository;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\DeleteQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Contract\UpdateQuestionContract;
use Component\Question\Sdk\Model\QuestionRead;
use Illuminate\Support\Collection;

class QuestionServiceImpl implements QuestionService
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getAllQuestions(GetQuestionsContract $contract): Collection
    {
        return $this->questionRepository->getAllQuestions($contract);
    }

    public function addQuestion(AddQuestionContract $contract, int $authUserId): QuestionRead
    {
        return $this->questionRepository->addQuestion($contract, $authUserId);
    }

    public function deleteQuestion(DeleteQuestionContract $contract, int $authUserId): void
    {
        $this->questionRepository->deleteQuestion($contract, $authUserId);
    }

    public function updateQuestion(UpdateQuestionContract $contract, int $authUserId): QuestionRead
    {
        return $this->questionRepository->updateQuestion($contract, $authUserId);
    }
}
