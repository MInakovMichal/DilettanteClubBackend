<?php

namespace Component\Room\Infrastructure\Checker;

use Common\Exception\InvalidArgumentException;
use Component\Question\Sdk\QuestionFacade;

class RoomQuestionAuthorCheckerImpl implements RoomQuestionAuthorChecker
{
    private QuestionFacade $questionFacade;

    /**
     * @param QuestionFacade $questionFacade
     */
    public function __construct(QuestionFacade $questionFacade)
    {
        $this->questionFacade = $questionFacade;
    }

    public function check(int $questionId, int $userId): void
    {
        $question = $this->questionFacade->findByIdOrFail($questionId);

        if ($question->getUserId() !== $userId) {
            throw new InvalidArgumentException('Can not delete question from room with id: ' . $questionId);
        }
    }
}
