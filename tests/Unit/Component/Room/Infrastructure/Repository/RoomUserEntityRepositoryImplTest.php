<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Component\Room\Infrastructure\Http\Requests\UserLeaveRoomRequest;
use Component\Room\Infrastructure\Repository\RoomUserEntityRepository;
use Tests\TestCase;

class RoomUserEntityRepositoryImplTest extends TestCase
{
    private RoomUserEntityRepository $repositoryImpl;

    private User $user;

    public function test_UserEnterToRoom_ShouldAddNewPunishments_WhenUserAddPunishments(): void
    {
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        $usersInRoomBeforeAddNew = RoomUser::all();
        $this->assertSame(0, $usersInRoomBeforeAddNew->count());

        $this->repositoryImpl->userEnterRoom($room->getId(), $this->user->getId());
        $usersInRoomAfterAddNew = RoomUser::all();

        $this->assertSame(1, $usersInRoomAfterAddNew->count());
    }

    public function test_UserLeaveRoom_ShouldDeleteUserFromRoom_WhenUserLeaveRoom(): void
    {
        $room = Room::factory()->create([
            'user_id' => $this->user->getId(),
        ]);

        RoomUser::factory()->create([
            'room_id' => $room->getId(),
            'user_id' => $this->user->getId()
        ]);

        $usersInRoomBeforeEnter = RoomUser::all();
        $this->assertSame(1, $usersInRoomBeforeEnter->count());

        $this->repositoryImpl->userLeaveRoom($room->getId(), $this->user->getId());
        $usersInRoomAfterEnter = RoomUser::all();

        $this->assertSame(0, $usersInRoomAfterEnter->count());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomUserEntityRepository::class);
    }

}
