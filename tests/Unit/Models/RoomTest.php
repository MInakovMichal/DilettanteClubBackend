<?php

namespace Tests\Unit\Models;

use App\Models\Language;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomTest extends TestCase
{
    private Room $room;
    private int $id;
    private string $name;
    private bool $isPrivate;
    private User $user;
    private Language $language;
    private string $password;

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

    public function test_IsPrivate_ShouldReturnTrue_WhenRoomIsPublic(): void
    {
        $this->assertTrue($this->room->isPrivate());
    }

    public function test_GetLanguageId_ShouldReturnLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->room->getLanguageId());
    }

    public function test_GetPassword_ShouldReturnPassword(): void
    {
        $this->assertTrue(Hash::check($this->password, $this->room->getPassword()));
    }

    public function test_SetUserId_ShouldChangeUserId(): void
    {
        $newUser = User::factory()->make(['id' => $this->user->getId() + 1]);

        $this->room->setUserId($newUser->getId());
        $this->assertSame($newUser->getId(), $this->room->getUserId());
    }

    public function test_SetUseCount_ShouldChangeUseCount(): void
    {
        $newName = $this->faker->name();

        $this->room->setName($newName);
        $this->assertSame($newName, $this->room->getName());
    }

    public function test_SetLanguageId_ShouldChangeLanguageId(): void
    {
        $newLanguage = Language::where('id', '!=', $this->language->getId())->firstOrFail();

        $this->room->setLanguageId($newLanguage->getId());
        $this->assertSame($newLanguage->getId(), $this->room->getLanguageId());
    }

    public function test_SetIsPrivate_ShouldChangeRoomPrivate(): void
    {
        $newIsPrivate = !$this->room->isPrivate();

        $this->room->setIsPrivate($newIsPrivate);
        $this->assertSame($newIsPrivate, $this->room->isPrivate());
    }

    public function test_SetPassword_ShouldChangePassword(): void
    {
        $newPassword = Hash::make($this->faker->password());

        $this->room->setPassword($newPassword);
        $this->assertSame($newPassword, $this->room->password);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->id = 1;
        $this->name = $this->faker()->name();
        $this->isPrivate = true;
        $this->language = Language::firstOrFail();
        $this->password = $this->faker->password();

        $this->room = Room::factory()->make([
            'id' => $this->id,
            'is_private' => $this->isPrivate,
            'name' => $this->name,
            'user_id' => $this->user->getId(),
            'language_id' => $this->language->getId(),
            'password' => Hash::make($this->password)
        ]);
    }
}
