<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Component\Room\Infrastructure\Repository\RoomUserEntityRepository;
use Tests\TestCase;

class RoomUserEntityRepositoryImplTest extends TestCase
{
    private RoomUserEntityRepository $repositoryImpl;

    private User $user;

    public function test_AddPunishmentsToRoom_ShouldAddNewPunishments_WhenUserAddPunishments(): void
    {
        $room = Room::factory()->create(['author_id' => $this->user->getId()]);

        $usersInRoomBeforeAddNew = RoomUser::all();
        $this->assertSame(0, $usersInRoomBeforeAddNew->count());

        $this->repositoryImpl->userEnterRoom($room->getId(), $this->user->getId());
        $usersInRoomAfterAddNew = RoomUser::all();

        $this->assertSame(1, $usersInRoomAfterAddNew->count());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomUserEntityRepository::class);
    }

}
