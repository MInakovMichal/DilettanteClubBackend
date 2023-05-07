<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\UserLeaveRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class UserLeaveRoomRequest extends FormRequest implements UserLeaveRoomContract
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
            'room_id' => ['required', 'int', 'exists:rooms,id'],
        ];
    }

    public function getRoomId(): int
    {
        /** @var int $roomId */
        $roomId = $this->get('room_id');

        return $roomId;
    }
}
