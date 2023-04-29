<?php

namespace Tests\Unit\Models;

use App\Models\Room;
use App\Models\User;
use Tests\TestCase;

class RoomTest extends TestCase
{
    private Room $room;

    private int $id;

    private string $name;

    private bool $isPrivate;

    private User $user;

    public function test_GetId_ShouldReturnAnswerId(): void
    {
        $this->assertSame($this->id, $this->room->getId());
    }

    public function test_GetUserId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->user->getId(), $this->room->getUserId());
    }

    public function test_GetName_ShouldReturnName(): void
    {
        $this->assertSame($this->name, $this->room->getName());
    }

    public function test_IsPrivate_ShouldReturnFalse(): void
    {
        $this->assertFalse($this->room->isPrivate());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->id = 1;
        $this->name = $this->faker()->name();
        $this->isPrivate = false;
        $this->room = Room::factory()->make(['id' => $this->id, 'is_private' => $this->isPrivate, 'name' => $this->name, 'user_id' => $this->user->getId()]);
    }
}
