<?php

namespace Component\Question\Infrastructure\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var int $id */
        $id = $this->__get('id');

        /** @var int $answer */
        $answer = $this->__get('answer');

        /** @var int $useCount */
        $useCount = $this->__get('use_count');

        /** @var string $question */
        $question = $this->__get('question');

        /** @var Language $language */
        $language = Language::findOrFail($this->__get('language_id'));/** @phpstan-ignore-line */

        $languageCode = $language->getCode();
        return [
            'id' => $id,
            'question' => $question,
            'answer' => $answer,
            'use_count' => $useCount,
            'language' => $languageCode,
        ];
    }
}
