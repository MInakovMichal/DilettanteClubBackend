<?php

namespace Component\Punishment\Infrastructure\Http\Requests;

use Component\Punishment\Sdk\Contract\AddPunishmentContract;
use Illuminate\Foundation\Http\FormRequest;

class AddPunishmentRequest extends FormRequest implements AddPunishmentContract
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
            'user' => ['required', 'integer', 'exists:users,id'],
            'punishment' => ['required', 'string'],
            'language_id' => ['required', 'integer', 'exists:languages,id']
        ];
    }

    public function getUserId(): int
    {
        /** @var int $userId */
        $userId = $this->get('user');

        return $userId;
    }

    public function getPunishment(): string
    {
        /** @var string $punishment */
        $punishment = $this->get('punishment');

        return $punishment;
    }

    public function getLanguageId(): int
    {
        /** @var int $userId */
        $userId = $this->get('language_id');

        return $userId;
    }
}
