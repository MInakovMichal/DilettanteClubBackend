<?php

namespace Component\Question\Infrastructure\Service;

use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Model\QuestionRead;
use Illuminate\Support\Collection;

interface QuestionService
{
    public function getAllQuestions(GetQuestionsContract $contract): Collection;

    public function addQuestion(AddQuestionContract $contract): QuestionRead;
}
