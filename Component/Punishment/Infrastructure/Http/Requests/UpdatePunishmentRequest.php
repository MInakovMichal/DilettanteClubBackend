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

    /**
     * Transform the resource into an array.
     *
     * @return array<string,mixed>
     */
    public function messages(): array
    {
        return [
            'id' => [
                'required' => 'The id field is required.',
                'int' => 'The id field must be an integer.',
                'exists' => 'The selected id is invalid.',
            ],
            'punishment' => [
                'required' => 'The punishment field is required.',
                'string' => 'The punishment field must be a string.',
            ],
            'language_id' => [
                'required' => 'The language_id field is required.',
                'integer' => 'The language_id field must be an integer.',
                'exists' => 'The selected language_id is invalid.',
            ],
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
