<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class AddPunishmentsToRoomRequest extends FormRequest implements AddPunishmentsToRoomContract
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
