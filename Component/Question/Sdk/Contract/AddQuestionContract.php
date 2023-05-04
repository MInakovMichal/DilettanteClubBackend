<?php

namespace Component\Question\Sdk\Contract;

interface AddQuestionContract
{
    public function getQuestion(): string;

    public function getAnswer(): int;

    public function getLanguageId(): int;
}
