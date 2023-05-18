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
     * Transform the resource into an array.
     *
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'punishment.required' => 'The punishment field is required.',
            'punishment.string' => 'The punishment must be a string.',

            'language_id.required' => 'The language field is required.',
            'language_id.integer' => 'The language must be an integer.',
            'language_id.exists' => 'The selected language is invalid.',
        ];
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
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
        /** @var int $userId */
        $userId = $this->get('language_id');

        return $userId;
    }
}
