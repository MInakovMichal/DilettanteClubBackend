<?php

namespace Component\Question\Infrastructure\Http\Requests;

use Component\Question\Sdk\Contract\AddQuestionContract;
use Illuminate\Foundation\Http\FormRequest;

class AddQuestionRequest extends FormRequest implements AddQuestionContract
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
            'user' => ['required', 'integer', 'exists:users,id'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'integer'],
            'language_id' => ['required', 'integer', 'exists:languages,id']
        ];
    }

    public function getUserId(): int
    {
        /** @var int $userId */
        $userId = $this->get('user');

        return $userId;
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
        /** @var int $userId */
        $userId = $this->get('language_id');

        return $userId;
    }
}
