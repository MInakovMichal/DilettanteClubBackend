<?php

declare(strict_types=1);

namespace Component\Punishment\Sdk\Model;

use Illuminate\Contracts\Support\Arrayable;

final class PunishmentRead implements Arrayable
{
    private int $id;

    private int $userId;

    private string $punishment;

    private int $useCount;

    private int $languageId;

    /**
     * @param int $id
     * @param string $punishment
     * @param int $useCount
     * @param int $languageId
     * @param int $userId
     */
    public function __construct(int $id, int $userId, string $punishment, int $useCount, int $languageId)
    {
        $this->id = $id;
        $this->punishment = $punishment;
        $this->useCount = $useCount;
        $this->languageId = $languageId;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPunishment(): string
    {
        return $this->punishment;
    }

    /**
     * @return int
     */
    public function getUseCount(): int
    {
        return $this->useCount;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'punishment' => $this->punishment,
            'use_count' => $this->useCount,
            'language_id' => $this->languageId
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
