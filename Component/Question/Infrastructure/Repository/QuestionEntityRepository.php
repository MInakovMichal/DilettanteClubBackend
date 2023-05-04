<?php

namespace Component\Question\Infrastructure\Repository;

use App\Models\Question;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\DeleteQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Contract\UpdateQuestionContract;
use Illuminate\Support\Collection;

interface QuestionEntityRepository
{
    public function getAllQuestions(GetQuestionsContract $contract): Collection;

    public function addQuestion(AddQuestionContract $contract, int $authUserId): Question;

    public function deleteQuestion(DeleteQuestionContract $contract, int $authUserId): void;

    public function updateQuestion(UpdateQuestionContract $contract, int $authUserId): Question;

    public function findByIdOrFail(int $id): Question;
}
