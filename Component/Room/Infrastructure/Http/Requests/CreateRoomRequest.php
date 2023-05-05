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
            'is_private' => ['required', 'boolean', 'exists:languages,id'],
            'password' => ['required_if:field1,true', 'string', 'min:8', 'max:' . $maxLength, 'confirmed', 'regex:' . $regexRule]
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
