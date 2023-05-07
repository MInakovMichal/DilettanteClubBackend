<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Punishment;
use App\Models\Room;
use App\Models\RoomPunishment;
use App\Models\User;
use Common\Exception\RoomPunishmentByIdNotFoundException;
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

    public function test_DeletePunishmentFromRoom_ShouldDeletePunishmentFromRoom(): void
    {
        $punishment = Punishment::factory()->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['author_id' => $this->user->getId()]);

        RoomPunishment::factory()->create([
            'room_id' => $room->getId(),
            'punishment_id' => $punishment->getId()
        ]);

        $punishmentsInRoomBeforeDelete = RoomPunishment::all();
        $this->assertSame(1, $punishmentsInRoomBeforeDelete->count());

        $this->repositoryImpl->deletePunishmentFromRoom($room->getId(), $punishment->getId());
        $punishmentsInRoomAfterDelete = RoomPunishment::all();

        $this->assertSame(0, $punishmentsInRoomAfterDelete->count());
    }

    public function test_FindByIdAndRoomIdOrFail_ShouldThrowRoomPunishmentByIdNotFoundException_WhenQuestionNotFoundInRoom(): void
    {
        $this->expectException(RoomPunishmentByIdNotFoundException::class);

        $roomId = 1;
        $punishmentId = 1;
        $this->repositoryImpl->findByIdAndRoomIdOrFail($roomId, $punishmentId);
    }

    public function test_FindByIdAndRoomIdOrFail_ShouldReturnRoomPunishment_WhenQuestionWasFoundInRoom(): void
    {
        $room = Room::factory()->create();
        $punishment = Punishment::factory()->create();

        RoomPunishment::factory()->create([
            'room_id' => $room->getId(),
            'punishment_id' => $punishment->getId()
        ]);

        $roomPunishment = $this->repositoryImpl->findByIdAndRoomIdOrFail($room->getId(), $punishment->getId());

        $this->assertInstanceOf(RoomPunishment::class, $roomPunishment);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomPunishmentEntityRepository::class);
    }

}
