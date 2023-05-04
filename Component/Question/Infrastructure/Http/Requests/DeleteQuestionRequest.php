<?php

namespace Component\Question\Infrastructure\Http\Requests;

use Component\Question\Sdk\Contract\DeleteQuestionContract;
use Illuminate\Foundation\Http\FormRequest;

class DeleteQuestionRequest extends FormRequest implements DeleteQuestionContract
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
            'id' => ['required', 'int', 'exists:questions,id'],
        ];
    }

    public function getQuestionId(): int
    {
        /** @var int $questionId */
        $questionId = $this->get('id');

        return $questionId;
    }
}
