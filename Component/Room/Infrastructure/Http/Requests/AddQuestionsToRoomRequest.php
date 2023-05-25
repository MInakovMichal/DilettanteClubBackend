<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\AddQuestionsToRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class AddQuestionsToRoomRequest extends FormRequest implements AddQuestionsToRoomContract
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
            'questions' => ['required', 'array', 'min:1'],
            'questions.*' => ['required', 'int', 'distinct', 'exists:questions,id'],
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
            'questions' => [
                'required' => 'The questions field is required.',
                'array' => 'The questions field must be an array.',
                'min' => 'The questions field must have at least :min item(s).',
            ],
            'questions.*' => [
                'required' => 'Each question item is required.',
                'int' => 'Each question item must be an integer.',
                'distinct' => 'Each question item must be unique.',
                'exists' => 'Each question item is invalid.',
            ],
        ];
    }

    public function getQuestions(): array
    {
        /** @var array<int,int> $questions */
        $questions = $this->get('questions');

        return $questions;
    }
}
