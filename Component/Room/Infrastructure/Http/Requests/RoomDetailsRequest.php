<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\RoomDetailsContract;
use Illuminate\Foundation\Http\FormRequest;

class RoomDetailsRequest extends FormRequest implements RoomDetailsContract
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
            'room_id' => [
                'required' => 'The room_id field is required.',
                'int' => 'The room_id field must be an integer.',
                'exists' => 'The selected room_id is invalid.',
            ],
        ];
    }

    public function getRoomId(): int
    {
        /** @var int $roomId */
        $roomId = $this->get('room_id');

        return $roomId;
    }
}
