<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\DeletePunishmentsFromRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class DeletePunishmentsFromRoomRequest extends FormRequest implements DeletePunishmentsFromRoomContract
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
            'punishments' => ['required', 'array', 'min:1'],
            'punishments.*' => ['required', 'int', 'distinct', 'exists:punishments,id'],
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
            'punishments' => [
                'required' => 'The punishments field is required.',
                'array' => 'The punishments field must be an array.',
                'min' => 'The punishments field must have at least :min item(s).',
            ],
            'punishments.*' => [
                'required' => 'Each punishment item is required.',
                'int' => 'Each punishment item must be an integer.',
                'distinct' => 'Each punishment item must be unique.',
                'exists' => 'Each punishment item is invalid.',
            ],
            'room_id' => [
                'required' => 'The room_id field is required.',
                'int' => 'The room_id field must be an integer.',
                'exists' => 'The selected room_id is invalid.',
            ],
        ];
    }

    public function getPunishments(): array
    {
        /** @var array<int,int> $punishments */
        $punishments = $this->get('punishments');

        return $punishments;
    }

    public function getRoomId(): int
    {
        /** @var int $roomId */
        $roomId = $this->get('room_id');

        return $roomId;
    }
}
