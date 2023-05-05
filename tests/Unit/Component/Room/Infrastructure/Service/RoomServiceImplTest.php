<?php

namespace Tests\Unit\Component\Room\Infrastructure\Service;

use App\Models\Language;
use App\Models\User;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Infrastructure\Service\RoomService;
use Component\Room\Sdk\Model\RoomRead;
use Tests\TestCase;

class RoomServiceImplTest extends TestCase
{
    private RoomService $serviceImpl;

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

        $roomRead = $this->serviceImpl->createRoom($contract, $this->user->getId());

        $this->assertInstanceOf(RoomRead::class, $roomRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutRooms = User::factory()->create();

        $this->serviceImpl = resolve(RoomService::class);
    }
}
