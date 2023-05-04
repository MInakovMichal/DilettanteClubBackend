<?php

declare(strict_types=1);

namespace Common\Exception;

class QuestionByIdNotFoundException extends ApiException
{
    public const MESSAGE = "Question not found with id: ";

    public function __construct(int $id)
    {
        parent::__construct(self::MESSAGE . $id, 404, ['question_id' => $id]);
    }
}
