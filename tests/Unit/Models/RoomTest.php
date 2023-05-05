<?php

namespace Tests\Unit\Models;

use App\Models\Language;
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

    private Language $language;

    public function test_GetId_ShouldReturnAnswerId(): void
    {
        $this->assertSame($this->id, $this->room->getId());
    }

    public function test_GetAuthorId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->user->getId(), $this->room->getAuthorId());
    }

    public function test_GetName_ShouldReturnName(): void
    {
        $this->assertSame($this->name, $this->room->getName());
    }

    public function test_IsPrivate_ShouldReturnFalse_WhenRoomIsPublic(): void
    {
        $this->assertFalse($this->room->isPrivate());
    }

    public function test_GetLanguageId_ShouldReturnLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->room->getLanguageId());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->id = 1;
        $this->name = $this->faker()->name();
        $this->isPrivate = false;
        $this->language = Language::firstOrFail();
        $this->room = Room::factory()->make([
            'id' => $this->id,
            'is_private' => $this->isPrivate,
            'name' => $this->name,
            'author_id' => $this->user->getId(),
            'language_id' => $this->language->getId(),
        ]);
    }
}
