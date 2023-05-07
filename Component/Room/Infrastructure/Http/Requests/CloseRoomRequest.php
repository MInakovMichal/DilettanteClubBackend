<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\CloseRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class CloseRoomRequest extends FormRequest implements CloseRoomContract
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

    public function getRoomId(): int
    {
        /** @var int $roomId */
        $roomId = $this->get('room_id');

        return $roomId;
    }
}
