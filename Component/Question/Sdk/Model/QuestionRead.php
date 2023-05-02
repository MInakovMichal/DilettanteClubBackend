<?php

declare(strict_types=1);

namespace Component\Question\Sdk\Model;

use Illuminate\Contracts\Support\Arrayable;

final class QuestionRead implements Arrayable
{
    private int $id;

    private string $question;

    private int $answer;

    private int $useCount;

    private int $languageId;

    /**
     * @param int $id
     * @param string $question
     * @param int $answer
     * @param int $useCount
     * @param int $languageId
     */
    public function __construct(int $id, string $question, int $answer, int $useCount, int $languageId)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->useCount = $useCount;
        $this->languageId = $languageId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return int
     */
    public function getAnswer(): int
    {
        return $this->answer;
    }

    /**
     * @return int
     */
    public function getUseCount(): int
    {
        return $this->useCount;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'use_count' => $this->useCount,
            'language_id' => $this->languageId
        ];
    }

}
