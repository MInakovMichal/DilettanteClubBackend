<?php

namespace Component\Question\Domain;

use Component\Question\Infrastructure\Service\QuestionService;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Model\QuestionRead;
use Component\Question\Sdk\QuestionFacade;
use Illuminate\Support\Collection;

class QuestionFacadeImpl implements QuestionFacade
{
    private QuestionService $questionService;

    /**
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function getAllQuestions(GetQuestionsContract $contract): Collection
    {
        return $this->questionService->getAllQuestions($contract);
    }

    public function addQuestion(AddQuestionContract $contract): QuestionRead
    {
        return $this->questionService->addQuestion($contract);
    }
}
