<?php

namespace Component\Question\Infrastructure\Http\Requests;

use Component\Question\Sdk\Contract\UpdateQuestionContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest implements UpdateQuestionContract
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', 'exists:questions,id'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'integer'],
            'language_id' => ['required', 'integer', 'exists:languages,id']
        ];
    }

    public function getQuestion(): string
    {
        /** @var string $question */
        $question = $this->get('question');

        return $question;
    }

    public function getAnswer(): int
    {
        /** @var int $answer */
        $answer = $this->get('answer');

        return $answer;
    }

    public function getLanguageId(): int
    {
        /** @var int $languageId */
        $languageId = $this->get('language_id');

        return $languageId;
    }

    public function getQuestionId(): int
    {
        /** @var int $questionId */
        $questionId = $this->get('id');

        return $questionId;
    }
}
