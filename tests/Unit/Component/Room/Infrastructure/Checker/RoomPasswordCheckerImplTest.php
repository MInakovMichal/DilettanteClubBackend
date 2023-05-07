<?php

namespace Tests\Unit\Component\Room\Infrastructure\Checker;

use App\Models\Room;
use Common\Exception\PasswordNotMatchException;
use Component\Room\Infrastructure\Checker\RoomPasswordChecker;
use Component\Room\Infrastructure\Http\Requests\UserEnterRoomRequest;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomPasswordCheckerImplTest extends TestCase
{
    private RoomPasswordChecker $checker;
    private string $password;
    private Room $room;

    public function test_Check_ShouldThrowPasswordNotMatchException_WhenPasswordNotMatch(): void
    {
        $this->expectException(PasswordNotMatchException::class);
        $request = new UserEnterRoomRequest([
            'password' => $this->password . '_new',
            'is_private' => true,
            'room_id' => $this->room->getId()
        ]);

        $this->checker->check($request);
    }

    public function test_Check_ShouldReturnAuthenticatedClass_WhenPasswordIsMatch(): void
    {
        $request = new UserEnterRoomRequest([
            'password' => $this->password,
            'is_private' => true,
            'room_id' => $this->room->getId()
        ]);

        $this->assertNull($this->checker->check($request));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->password = $this->faker->password();
        $this->room = Room::factory()->create([
            'password' => Hash::make($this->password),
        ]);

        $this->checker = app(RoomPasswordChecker::class);
    }
}
