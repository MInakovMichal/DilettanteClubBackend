<?php

namespace Component\Question\Infrastructure\Repository;

use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\DeleteQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Contract\UpdateQuestionContract;
use Component\Question\Sdk\Model\QuestionRead;
use Illuminate\Support\Collection;

interface QuestionRepository
{
    public function getAllQuestions(GetQuestionsContract $contract): Collection;

    public function addQuestion(AddQuestionContract $contract, int $authUserId): QuestionRead;

    public function deleteQuestion(DeleteQuestionContract $contract, int $authUserId): void;

    public function updateQuestion(UpdateQuestionContract $contract, int $authUserId): QuestionRead;

    public function findByIdOrFail(int $id): QuestionRead;
}
