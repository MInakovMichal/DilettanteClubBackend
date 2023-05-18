<?php

namespace Component\Question\Infrastructure\Http\Requests;

use Component\Question\Sdk\Contract\GetQuestionsContract;
use Illuminate\Foundation\Http\FormRequest;

class GetQuestionsRequest extends FormRequest implements GetQuestionsContract
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
            'user' => ['required', 'integer', 'exists:users,id']
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
            'user' => [
                'required' => 'The user field is required.',
                'integer' => 'The user field must be an integer.',
                'exists' => 'The selected user is invalid.',
            ],
        ];
    }

    public function getUserId(): int
    {
        /** @var int $userId */
        $userId = $this->get('user');

        return $userId;
    }
}
