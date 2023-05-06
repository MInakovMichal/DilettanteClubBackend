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
            'room_id' => ['required', 'int', 'exists:rooms,id']
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
