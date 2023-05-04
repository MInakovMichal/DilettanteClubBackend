<?php

namespace Component\Question\Infrastructure\Repository;

use App\Models\Question;
use Common\Exception\QuestionByIdNotFoundException;
use Common\Exception\UnauthorizedException;
use Component\Question\Sdk\Contract\AddQuestionContract;
use Component\Question\Sdk\Contract\DeleteQuestionContract;
use Component\Question\Sdk\Contract\GetQuestionsContract;
use Component\Question\Sdk\Contract\UpdateQuestionContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function addQuestion(AddQuestionContract $contract, int $authUserId): Question
    {
        try {
            /** @var Question $question */
            $question = $this->entity::create([
                'user_id' => $authUserId,
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

    public function deleteQuestion(DeleteQuestionContract $contract, int $authUserId): void
    {
        $question = self::findByIdOrFail($contract->getQuestionId());
        if ($question->getUserId() === $authUserId) {
            $question->delete();
        } else {
            throw new UnauthorizedException();
        }
    }

    public function findByIdOrFail(int $id): Question
    {
        try {
            /** @var Question $question */
            $question = $this->entity->findOrFail($id);
            return $question;
        } catch (ModelNotFoundException $e) {
            throw new QuestionByIdNotFoundException($id);
        }
    }

    public function updateQuestion(UpdateQuestionContract $contract, int $authUserId): Question
    {
        $question = self::findByIdOrFail($contract->getQuestionId());

        if ($question->getUserId() === $authUserId) {
            $question->setQuestion($contract->getQuestion());
            $question->setAnswer($contract->getAnswer());
            $question->setLanguageId($contract->getLanguageId());

            $question->save();
            return $question;
        } else {
            throw new UnauthorizedException();
        }
    }
}
