<?php

namespace Tests\Unit\Models;


use App\Models\Question;
use App\Models\Room;
use App\Models\RoomQuestion;
use Tests\TestCase;

class RoomQuestionTest extends TestCase
{
    private RoomQuestion $roomQuestion;
    private int $id;
    private Room $room;
    private Question $question;
    private bool $inGame;
    private bool $isUsed;

    public function test_GetId_shouldReturnId(): void
    {
        $this->assertSame($this->id, $this->roomQuestion->getId());
    }

    public function test_GerRoomId_ShouldReturnRoomId(): void
    {
        $this->assertSame($this->room->getId(), $this->roomQuestion->getRoomId());
    }

    public function test_GetQuestionId_ShouldReturnQuestionId(): void
    {
        $this->assertSame($this->question->getId(), $this->roomQuestion->getQuestionId());
    }

    public function test_InGame_ShouldReturnTrue(): void
    {
        $this->assertTrue($this->roomQuestion->inGame());
    }

    public function test_IsUsed_ShouldReturnTrue(): void
    {
        $this->assertTrue($this->roomQuestion->isUsed());
    }

    public function test_SetRoomId_ShouldChangeRoomId(): void
    {
        $newRoom = Room::factory()->create();
        $this->roomQuestion->setRoomId($newRoom->getId());

        $this->assertSame($newRoom->getId(), $this->roomQuestion->getRoomId());
    }

    public function test_SetQuestionId_ShouldChangeQuestionId(): void
    {
        $newQuestion = Question::factory()->create();
        $this->roomQuestion->setQuestionId($newQuestion->getId());

        $this->assertSame($newQuestion->getId(), $this->roomQuestion->getQuestionId());
    }

    public function test_SetInGame_ShouldChangeInGame(): void
    {
        $this->roomQuestion->setInGame(!$this->inGame);

        $this->assertSame(!$this->inGame, $this->roomQuestion->inGame());
    }

    public function test_SetIsUsed_ShouldChangeIsUsed(): void
    {
        $this->roomQuestion->setIsUsed(!$this->isUsed);

        $this->assertSame(!$this->isUsed, $this->roomQuestion->isUsed());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = 1;
        $this->inGame = true;
        $this->isUsed = true;
        $this->room = Room::factory()->create();
        $this->question = Question::factory()->create();

        $this->roomQuestion = RoomQuestion::factory()->make([
            'id' => $this->id,
            'room_id' => $this->room->getId(),
            'question_id' => $this->question->getId(),
            'in_game' => $this->inGame,
            'is_used' => $this->isUsed
        ]);
    }
}
