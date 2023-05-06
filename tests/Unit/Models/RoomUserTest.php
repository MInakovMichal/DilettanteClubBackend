<?php

namespace Tests\Unit\Models;


use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Tests\TestCase;

class RoomUserTest extends TestCase
{
    private RoomUser $roomUser;
    private int $id;
    private Room $room;
    private User $user;
    private bool $isReady;
    private int $wins;
    private int $looses;

    public function test_GetId_shouldReturnId(): void
    {
        $this->assertSame($this->id, $this->roomUser->getId());
    }

    public function test_GerRoomId_ShouldReturnRoomId(): void
    {
        $this->assertSame($this->room->getId(), $this->roomUser->getRoomId());
    }

    public function test_GetUserId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->user->getId(), $this->roomUser->getUserId());
    }

    public function test_isReady_ShouldReturnTrue(): void
    {
        $this->assertTrue($this->roomUser->isReady());
    }

    public function test_GetWins_ShouldReturnUserWins(): void
    {
        $this->assertSame($this->wins, $this->roomUser->getWins());
    }

    public function test_GetLooses_ShouldReturnUserLooses(): void
    {
        $this->assertSame($this->looses, $this->roomUser->getLooses());
    }

    public function test_SetRoomId_ShouldChangeRoomId(): void
    {
        $newRoom = Room::factory()->create();
        $this->roomUser->setRoomId($newRoom->getId());

        $this->assertSame($newRoom->getId(), $this->roomUser->getRoomId());
    }

    public function test_SetUserId_ShouldChangeUserId(): void
    {
        $newUser = User::factory()->create();
        $this->roomUser->setUserId($newUser->getId());

        $this->assertSame($newUser->getId(), $this->roomUser->getUserId());
    }

    public function test_SetIsReady_ShouldChangeIsUsed(): void
    {
        $this->roomUser->setIsReady(!$this->isReady);

        $this->assertSame(!$this->isReady, $this->roomUser->isReady());
    }

    public function test_SetWins_ShouldChangeWins(): void
    {
        $newWins = $this->wins + 1;
        $this->roomUser->setWins($newWins);

        $this->assertSame($newWins, $this->roomUser->getWins());
    }

    public function test_SetWLooses_ShouldChangeWLooses(): void
    {
        $newLooses = $this->looses + 1;
        $this->roomUser->setLooses($newLooses);

        $this->assertSame($newLooses, $this->roomUser->getLooses());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = 1;
        $this->isReady = true;
        $this->wins = $this->faker->randomDigit();
        $this->looses = $this->faker->randomDigit();
        $this->room = Room::factory()->create();
        $this->user = User::factory()->create();

        $this->roomUser = RoomUser::factory()->make([
            'id' => $this->id,
            'room_id' => $this->room->getId(),
            'user_id' => $this->user->getId(),
            'is_ready' => $this->isReady,
            'wins' => $this->wins,
            'looses' => $this->looses
        ]);
    }
}
