<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Language;
use App\Models\Room;
use App\Models\User;
use Common\Exception\RoomByIdNotFoundException;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Infrastructure\Repository\RoomEntityRepository;
use Tests\TestCase;

class RoomEntityRepositoryImplTest extends TestCase
{
    private RoomEntityRepository $repositoryImpl;

    private User $user;

    public function test_CreateRoom_ShouldReturnRoomReadClass_WhenUserCreateRoom(): void
    {
        $roomValue = $this->faker->sentence();
        $language = Language::firstOrFail();

        $contract = new CreateRoomRequest([
            'name' => $roomValue,
            'is_private' => false,
            'language_id' => $language->getId()
        ]);

        $roomRead = $this->repositoryImpl->createRoom($contract, $this->user->getId());

        $this->assertInstanceOf(Room::class, $roomRead);
    }

    public function test_FindByIdOrFail_ShouldThrowRoomByIdNotFoundException_WhenRoomNotFound(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();
        $this->expectException(RoomByIdNotFoundException::class);
        $this->repositoryImpl->findByIdOrFail($room->getId() + 1);
    }

    public function test_FindByIdOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();

        $roomRead = $this->repositoryImpl->findByIdOrFail($room->getId());

        $this->assertInstanceOf(Room::class, $roomRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutRooms = User::factory()->create();

        $this->repositoryImpl = resolve(RoomEntityRepository::class);
    }
}
