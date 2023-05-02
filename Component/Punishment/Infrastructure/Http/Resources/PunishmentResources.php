<?php

namespace Component\Punishment\Infrastructure\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PunishmentResources extends JsonResource
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

        /** @var int $useCount */
        $useCount = $this->__get('use_count');

        /** @var string $punishment */
        $punishment = $this->__get('punishment');

        /** @var Language $language */
        $language = Language::findOrFail($this->__get('language_id'));/** @phpstan-ignore-line */

        $languageCode = $language->getCode();
        return [
            'id' => $id,
            'question' => $punishment,
            'use_count' => $useCount,
            'language' => $languageCode,
        ];
    }
}
