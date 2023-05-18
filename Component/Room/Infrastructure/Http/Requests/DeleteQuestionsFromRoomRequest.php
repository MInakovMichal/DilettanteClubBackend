<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\DeleteQuestionsFromRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class DeleteQuestionsFromRoomRequest extends FormRequest implements DeleteQuestionsFromRoomContract
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
            'room_id' => ['required', 'int', 'exists:rooms,id']
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
            'room_id' => [
                'required' => 'The room_id field is required.',
                'int' => 'The room_id field must be an integer.',
                'exists' => 'The selected room_id is invalid.',
            ],
        ];
    }

    public function getQuestions(): array
    {
        /** @var array<int,int> $questions */
        $questions = $this->get('questions');

        return $questions;
    }

    public function getRoomId(): int
    {
        /** @var int $roomId */
        $roomId = $this->get('room_id');

        return $roomId;
    }
}
