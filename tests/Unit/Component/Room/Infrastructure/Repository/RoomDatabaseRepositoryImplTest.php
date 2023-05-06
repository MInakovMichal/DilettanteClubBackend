<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Room;
use App\Models\RoomUser;
use Component\Room\Infrastructure\Repository\RoomDatabaseRepository;
use Tests\TestCase;

class RoomDatabaseRepositoryImplTest extends TestCase
{
    private RoomDatabaseRepository $repositoryImpl;
    private int $usersCount;
    private Room $room;

    public function test_GetUsersInRoom_ShouldReturnCollectionWithTenElements(): void
    {
        $usersInRoom = $this->repositoryImpl->getUsersInRoom($this->room->getId());

        $this->assertSame($this->usersCount, count($usersInRoom));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->usersCount = 10;
        $this->room = Room::factory()->create();
        RoomUser::factory($this->usersCount)->create([
            'room_id' => $this->room->getId()
        ]);

        $this->repositoryImpl = resolve(RoomDatabaseRepository::class);
    }

}
