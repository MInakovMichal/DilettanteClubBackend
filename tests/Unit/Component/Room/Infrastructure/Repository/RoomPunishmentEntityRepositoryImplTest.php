<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Punishment;
use App\Models\Room;
use App\Models\RoomPunishment;
use App\Models\User;
use Component\Room\Infrastructure\Repository\RoomPunishmentEntityRepository;
use Tests\TestCase;

class RoomPunishmentEntityRepositoryImplTest extends TestCase
{
    private RoomPunishmentEntityRepository $repositoryImpl;

    private User $user;

    public function test_AddPunishmentsToRoom_ShouldAddNewPunishments_WhenUserAddPunishments(): void
    {
        $punishment = Punishment::factory()->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['author_id' => $this->user->getId()]);

        $punishmentsInRoomBeforeAddNew = RoomPunishment::all();
        $this->assertSame(0, $punishmentsInRoomBeforeAddNew->count());

        $this->repositoryImpl->addPunishmentToRoom($room->getId(), $punishment->getId());
        $punishmentsInRoomAfterAddNew = RoomPunishment::all();

        $this->assertSame(1, $punishmentsInRoomAfterAddNew->count());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomPunishmentEntityRepository::class);
    }

}
