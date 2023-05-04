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

    public function getPunishmentId(): int
    {
        /** @var int $punishmentId */
        $punishmentId = $this->get('id');

        return $punishmentId;
    }
}
