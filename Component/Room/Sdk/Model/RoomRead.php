<?php

namespace Component\Room\Sdk\Model;

use Common\Util\Arrayable;

class RoomRead implements Arrayable
{
    private int $id;

    private int $userId;

    private string $name;

    private bool $isPrivate;

    private int $languageId;

    /**
     * @param int $id
     * @param int $userId
     * @param string $name
     * @param bool $isPrivate
     */
    public function __construct(int $id, int $userId, string $name, bool $isPrivate, int $languageId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->isPrivate = $isPrivate;
        $this->languageId = $languageId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getuserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->isPrivate;
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
            'name' => $this->name,
            'is_private' => $this->isPrivate,
            'language_id' => $this->languageId
        ];
    }
}
