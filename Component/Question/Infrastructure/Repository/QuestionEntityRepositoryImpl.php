<?php

namespace Component\Question\Infrastructure\Repository;

use App\Models\Question;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Illuminate\Support\Collection;
use Throwable;
use UnexpectedValueException;

class QuestionEntityRepositoryImpl implements QuestionEntityRepository
{
    private Question $entity;

    public function __construct(Question $entity)
    {
        $this->entity = $entity;
    }

    public function getAllQuestions(GetQuestionsContract $contract): Collection
    {
        $userId = $contract->getUserId();
        return $this->entity->where('user_id', $userId)->get();
    }

    public function addQuestion(AddQuestionContract $contract): Question
    {
        try {
            /** @var Question $question */
            $question = $this->entity::create([
                'user_id' => $contract->getUserId(),
                'question' => $contract->getQuestion(),
                'answer' => $contract->getAnswer(),
                'language_id' => $contract->getLanguageId(),
                'use_count' => 0,
            ]);/** @phpstan-ignore-line */

            return $question;
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }
}
