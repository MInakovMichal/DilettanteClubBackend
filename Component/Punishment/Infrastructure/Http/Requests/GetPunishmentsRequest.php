<?php

namespace Component\Punishment\Infrastructure\Http\Requests;

use Component\Punishment\Sdk\Contract\GetPunishmentsContract;
use Illuminate\Foundation\Http\FormRequest;

class GetPunishmentsRequest extends FormRequest implements GetPunishmentsContract
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
            'user' => ['required', 'integer', 'exists:users,id']
        ];
    }

    public function getUserId(): int
    {
        /** @var int $userId */
        $userId = $this->get('user');

        return $userId;
    }
}
