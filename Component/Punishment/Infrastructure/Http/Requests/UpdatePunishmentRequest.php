<?php

namespace Component\Punishment\Infrastructure\Http\Requests;

use Component\Punishment\Sdk\Contract\UpdatePunishmentContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePunishmentRequest extends FormRequest implements UpdatePunishmentContract
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
            'id' => ['required', 'int', 'exists:punishments,id'],
            'punishment' => ['required', 'string'],
            'language_id' => ['required', 'integer', 'exists:languages,id']
        ];
    }

    public function getPunishment(): string
    {
        /** @var string $punishment */
        $punishment = $this->get('punishment');

        return $punishment;
    }

    public function getLanguageId(): int
    {
        /** @var int $languageId */
        $languageId = $this->get('language_id');

        return $languageId;
    }

    public function getPunishmentId(): int
    {
        /** @var int $punishmentId */
        $punishmentId = $this->get('id');

        return $punishmentId;
    }
}
