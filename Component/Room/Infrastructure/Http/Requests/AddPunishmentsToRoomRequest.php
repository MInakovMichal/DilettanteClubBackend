<?php

namespace Component\Room\Infrastructure\Http\Requests;

use Component\Room\Sdk\Contract\AddPunishmentsToRoomContract;
use Illuminate\Foundation\Http\FormRequest;

class AddPunishmentsToRoomRequest extends FormRequest implements AddPunishmentsToRoomContract
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
            'punishments' => ['required', 'array', 'min:1'],
            'punishments.*' => ['required', 'int', 'distinct', 'exists:punishments,id'],
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
            'punishments' => [
                'required' => 'The punishments field is required.',
                'array' => 'The punishments field must be an array.',
                'min' => 'The punishments field must have at least :min item(s).',
            ],
            'punishments.*' => [
                'required' => 'Each punishment item is required.',
                'int' => 'Each punishment item must be an integer.',
                'distinct' => 'Each punishment item must be unique.',
                'exists' => 'Each punishment item is invalid.',
            ],
        ];
    }

    public function getPunishments(): array
    {
        /** @var array<int,int> $punishments */
        $punishments = $this->get('punishments');

        return $punishments;
    }
}
