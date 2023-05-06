<?php

namespace Tests\Unit\Models;


use App\Models\Punishment;
use App\Models\Room;
use App\Models\RoomPunishment;
use Tests\TestCase;

class RoomPunishmentTest extends TestCase
{
    private RoomPunishment $roomPunishment;
    private int $id;
    private Room $room;
    private Punishment $punishment;
    private bool $inGame;
    private bool $isUsed;

    public function test_GetId_shouldReturnId(): void
    {
        $this->assertSame($this->id, $this->roomPunishment->getId());
    }

    public function test_GerRoomId_ShouldReturnRoomId(): void
    {
        $this->assertSame($this->room->getId(), $this->roomPunishment->getRoomId());
    }

    public function test_GetPunishmentId_ShouldReturnPunishmentId(): void
    {
        $this->assertSame($this->punishment->getId(), $this->roomPunishment->getPunishmentId());
    }

    public function test_InGame_ShouldReturnTrue(): void
    {
        $this->assertTrue($this->roomPunishment->inGame());
    }

    public function test_IsUsed_ShouldReturnTrue(): void
    {
        $this->assertTrue($this->roomPunishment->isUsed());
    }

    public function test_SetRoomId_ShouldChangeRoomId(): void
    {
        $newRoom = Room::factory()->create();
        $this->roomPunishment->setRoomId($newRoom->getId());

        $this->assertSame($newRoom->getId(), $this->roomPunishment->getRoomId());
    }

    public function test_SetPunishmentId_ShouldChangePunishmentId(): void
    {
        $newPunishment = Punishment::factory()->create();
        $this->roomPunishment->setPunishmentId($newPunishment->getId());

        $this->assertSame($newPunishment->getId(), $this->roomPunishment->getPunishmentId());
    }

    public function test_SetInGame_ShouldChangeInGame(): void
    {
        $this->roomPunishment->setInGame(!$this->inGame);

        $this->assertSame(!$this->inGame, $this->roomPunishment->inGame());
    }

    public function test_SetIsUsed_ShouldChangeIsUsed(): void
    {
        $this->roomPunishment->setIsUsed(!$this->isUsed);

        $this->assertSame(!$this->isUsed, $this->roomPunishment->isUsed());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = 1;
        $this->inGame = true;
        $this->isUsed = true;
        $this->room = Room::factory()->create();
        $this->punishment = Punishment::factory()->create();

        $this->roomPunishment = RoomPunishment::factory()->make([
            'id' => $this->id,
            'room_id' => $this->room->getId(),
            'punishment_id' => $this->punishment->getId(),
            'in_game' => $this->inGame,
            'is_used' => $this->isUsed
        ]);
    }
}
