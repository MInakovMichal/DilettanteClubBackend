<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Common\Exception\RoomIsPublicException;
use Component\Room\Sdk\Contract\CreateRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest implements CreateRoomContract
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
            'name' => ['required', 'string'],
            'language_id' => ['required', 'integer', 'exists:languages,id'],
            'is_private' => ['required', 'boolean'],
            'password' => ['required_if:is_private,true', 'string', 'min:8', 'max:' . $maxLength, 'confirmed', 'regex:' . $regexRule],
            'password_confirmation' => ['required_if:is_private,true', 'string', 'min:8', 'max:' . $maxLength, 'regex:' . $regexRule],
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
            'name' => ['required' => 'The name field is required.', 'string' => 'The name field must be a string.'],
            'language_id' => [
                'required' => 'The language_id field is required.',
                'integer' => 'The language_id field must be an integer.',
                'exists' => 'The selected language_id is invalid.',
            ],
            'is_private' => ['required' => 'The is_private field is required.', 'boolean' => 'The is_private field must be a boolean.'],
            'password' => [
                'required_if' => 'The password field is required when is_private is true.',
                'string' => 'The password field must be a string.',
                'min' => 'The password field must be at least :min characters.',
                'max' => 'The password field may not be greater than :max characters.',
                'confirmed' => 'The password confirmation does not match.',
                'regex' => 'The password confirmation must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ],
            'password_confirmation' => [
                'required' => 'The password confirmation field is required.',
                'string' => 'The password confirmation field must be a string.',
                'min' => 'The password confirmation field must be at least :min characters.',
                'max' => 'The password confirmation field may not be greater than :max characters.',
                'regex' => 'The password confirmation must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ],
        ];
    }

    public function getName(): string
    {
        /** @var string $name */
        $name = $this->get('name');

        return $name;
    }

    public function getLanguageId(): int
    {
        /** @var int $languageId */
        $languageId = $this->get('language_id');

        return $languageId;
    }

    public function getPassword(): string
    {
        if (self::isPrivate()) {
            /** @var string $password */
            $password = $this->get('password');

            return $password;
        } else {
            throw new RoomIsPublicException();
        }
    }

    public function isPrivate(): bool
    {
        /** @var bool $isPrivate */
        $isPrivate = $this->get('is_private');

        return $isPrivate;
    }
}
