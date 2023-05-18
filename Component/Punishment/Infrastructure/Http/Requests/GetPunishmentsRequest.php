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

    /**
     * Transform the resource into an array.
     *
     * @return array<string,mixed>
     */
    public function messages(): array
    {
        return [
            'user' => [
                'required' => 'The user field is required.',
                'integer' => 'The user field must be an integer.',
                'exists' => 'The selected user is invalid.',
            ],
        ];
    }

    public function getUserId(): int
    {
        /** @var int $userId */
        $userId = $this->get('user');

        return $userId;
    }
}
