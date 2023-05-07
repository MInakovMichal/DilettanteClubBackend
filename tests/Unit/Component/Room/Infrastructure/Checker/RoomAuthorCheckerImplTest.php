<?php

namespace Tests\Unit\Component\Room\Infrastructure\Checker;

use App\Models\Room;
use App\Models\User;
use Common\Exception\InvalidArgumentException;
use Component\Room\Infrastructure\Checker\RoomAuthorChecker;
use Component\Room\Infrastructure\Http\Requests\CloseRoomRequest;
use Tests\TestCase;

class RoomAuthorCheckerImplTest extends TestCase
{
    private RoomAuthorChecker $checker;

    public function test_Check_ShouldThrowInvalidArgumentException_WhenDeleteRoomFromAnotherUser(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $room = Room::factory()->create();

        $contract = new CloseRoomRequest([
            'room_id' => $room->getId()
        ]);

        $this->checker->check($contract, $room->getId());
    }

    public function test_Check_ShouldDoNothing_WhenDeleteOwnRoom(): void
    {
        $room = Room::factory()->create([
            'user_id' => $this->user->getId()
        ]);

        $contract = new CloseRoomRequest([
            'room_id' => $room->getId()
        ]);

        $this->assertNull($this->checker->check($contract, $this->user->getId()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->checker = app(RoomAuthorChecker::class);
    }
}
