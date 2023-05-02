<?php

namespace Component\Question\Infrastructure\Repository;

use App\Models\Question;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Illuminate\Support\Collection;

interface QuestionEntityRepository
{
    public function getAllQuestions(GetQuestionsContract $contract): Collection;

    public function addQuestion(AddQuestionContract $contract): Question;
}
