<?php

namespace Component\Question\Infrastructure\Repository;

use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Model\QuestionRead;
use Illuminate\Support\Collection;

interface QuestionRepository
{
    public function getAllQuestions(GetQuestionsContract $contract): Collection;

    public function addQuestion(AddQuestionContract $contract): QuestionRead;
}
