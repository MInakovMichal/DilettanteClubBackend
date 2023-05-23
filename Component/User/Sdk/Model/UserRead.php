<?php

declare(strict_types=1);

namespace Component\User\Sdk\Model;

use Illuminate\Contracts\Support\Arrayable;

final class UserRead implements Arrayable
{
    private int $id;

    private string $name;

    private string $username;

    private string $email;

    private int|null $roomId;

    public function __construct(
        int $id,
        string $name,
        string $username,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'room_id' => $this->roomId
        ];
    }

    /**
     * @return int|null
     */
    public function getRoomId(): ?int
    {
        return $this->roomId;
    }

    /**
     * @param int|null $roomId
     */
    public function setRoomId(?int $roomId): void
    {
        $this->roomId = $roomId;
    }
}
