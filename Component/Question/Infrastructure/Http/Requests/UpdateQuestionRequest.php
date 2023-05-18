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

    /**
     * Transform the resource into an array.
     *
     * @return array<string,mixed>
     */
    public function messages(): array
    {
        return [
            'id' => [
                'required' => 'The id field is required.',
                'int' => 'The id field must be an integer.',
                'exists' => 'The selected id is invalid.',
            ],
            'question' => [
                'required' => 'The question field is required.',
                'string' => 'The question field must be a string.',
            ],
            'answer' => [
                'required' => 'The answer field is required.',
                'integer' => 'The answer field must be an integer.',
            ],
            'language_id' => [
                'required' => 'The language_id field is required.',
                'integer' => 'The language_id field must be an integer.',
                'exists' => 'The selected language_id is invalid.',
            ],
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
