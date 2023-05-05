<?php

namespace Tests\Unit\Component\Room\Sdk\Model;

use App\Models\Language;
use App\Models\User;
use Component\Room\Sdk\Model\RoomRead;
use Tests\TestCase;

class RoomReadTest extends TestCase
{
    private RoomRead $roomReadModel;
    private int $id;
    private string $name;
    private bool $isPrivate;
    private Language $language;
    private User $user;

    public function test_GetId_ShouldReturnRoomId(): void
    {
        $this->assertSame($this->id, $this->roomReadModel->getId());
    }

    public function test_GetName_ShouldReturnRoomName(): void
    {
        $this->assertSame($this->name, $this->roomReadModel->getName());
    }

    public function test_GetAuthorId_ShouldReturnRoomAuthorId(): void
    {
        $this->assertSame($this->user->getId(), $this->roomReadModel->getAuthorId());
    }

    public function test_GetLanguageId_ShouldReturnRoomLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->roomReadModel->getLanguageId());
    }

    public function test_IsPrivate_ShouldReturnFalse(): void
    {
        $this->assertFalse($this->roomReadModel->isPrivate());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->user = User::factory()->create();
        $this->name = $this->faker->name();
        $this->isPrivate = false;
        $this->language = Language::firstOrFail();

        $this->roomReadModel = new RoomRead(
            $this->id,
            $this->user->getId(),
            $this->name,
            $this->isPrivate,
            $this->language->getId()
        );
    }
}
