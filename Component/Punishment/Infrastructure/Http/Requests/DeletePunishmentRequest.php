<?php

namespace Component\Punishment\Infrastructure\Http\Requests;

use Component\Punishment\Sdk\Contract\DeletePunishmentContract;
use Illuminate\Foundation\Http\FormRequest;

class DeletePunishmentRequest extends FormRequest implements DeletePunishmentContract
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
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function messages(): array
    {
        return [
            'id' => [
                'required' => 'The ID field is required.',
                'int' => 'The ID field must be an integer.',
                'exists' => 'The selected ID is invalid.',
            ],
        ];
    }

    public function getPunishmentId(): int
    {
        /** @var int $punishmentId */
        $punishmentId = $this->get('id');

        return $punishmentId;
    }
}
