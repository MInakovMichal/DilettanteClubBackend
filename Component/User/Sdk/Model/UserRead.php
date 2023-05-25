<?php

declare(strict_types=1);

namespace Component\User\Sdk\Model;

use Common\Exception\UserIsNotInRoomException;
use Illuminate\Contracts\Support\Arrayable;

final class UserRead implements Arrayable
{
    private int $id;

    private string $name;

    private string $username;

    private string $email;

    private bool $inRoom;

    private int $roomId;

    public function __construct(
        int $id,
        string $name,
        string $username,
        string $email,
        bool $inRoom
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->inRoom = $inRoom;
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
            'in_room' => $this->inRoom
        ];
    }

    public function getRoomId(): int
    {
        if (!self::isInRoom()) {
            throw new UserIsNotInRoomException();
        }
        return $this->roomId;
    }

    public function setRoomId(int $roomId): void
    {
        $this->roomId = $roomId;
    }

    public function isInRoom(): bool
    {
        return $this->inRoom;
    }
}
