<?php

namespace Component\Question\Sdk\Contract;

interface UpdateQuestionContract
{
    public function getQuestionId(): int;

    public function getQuestion(): string;

    public function getAnswer(): int;

    public function getLanguageId(): int;
}
