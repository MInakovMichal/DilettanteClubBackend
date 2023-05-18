<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Common\Exception\InvalidArgumentException;
use Common\Exception\RoomIsPublicException;
use Component\Room\Sdk\Contract\UserEnterRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class UserEnterRoomRequest extends FormRequest implements UserEnterRoomContract
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
        /** @var string $maxLength */
        $maxLength = config('auth.maxPasswordLength');

        /** @var string $regexRule */
        $regexRule = config('auth.password_regex.rule');

        return [
            'room_id' => ['required', 'int', 'exists:rooms,id'],
            'is_private' => ['required', 'bool'],
            'password' => ['required_if:is_private,true', 'string', 'min:8', 'max:' . $maxLength, 'regex:' . $regexRule],
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
                'integer' => 'The room_id field must be an integer.',
                'exists' => 'The selected room_id is invalid.',
            ],
            'is_private' => [
                'required' => 'The is_private field is required.',
                'boolean' => 'The is_private field must be a boolean.',
            ],
            'password' => [
                'required_if' => 'The password field is required when is_private is true.',
                'string' => 'The password field must be a string.',
                'min' => 'The password field must be at least :min characters.',
                'max' => 'The password field may not be greater than :max characters.',
                'regex' => 'The password confirmation must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ],
        ];
    }

    public function getRoomId(): int
    {
        /** @var int $roomId */
        $roomId = $this->get('room_id');

        return $roomId;
    }

    public function getPassword(): string
    {
        if (!self::isPrivate()) {
            throw new RoomIsPublicException();
        }
        if (!self::hasPassword()) {
            throw new InvalidArgumentException('Password is not set');
        }

        /** @var string $password */
        $password = $this->get('password');

        return $password;
    }

    public function isPrivate(): bool
    {
        /** @var bool $isPrivate */
        $isPrivate = $this->get('is_private');

        return $isPrivate;
    }

    public function hasPassword(): bool
    {
        return $this->get('password') !== null;
    }
}
