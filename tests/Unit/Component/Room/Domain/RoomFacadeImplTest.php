<?php

namespace Tests\Unit\Component\Room\Domain;

use App\Models\Language;
use App\Models\User;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Sdk\Model\RoomRead;
use Component\Room\Sdk\RoomFacade;
use Tests\TestCase;

class RoomFacadeImplTest extends TestCase
{
    private RoomFacade $facadeImpl;

    private User $user;

    public function test_CreateRoom_ShouldReturnRoomReadClass_WhenUserCreateRoom(): void
    {
        $roomValue = $this->faker->name();

        /** @var Language $language */
        $language = Language::firstOrFail();

        $contract = new CreateRoomRequest([
            'name' => $roomValue,
            'is_private' => false,
            'language_id' => $language->getId()
        ]);

        $roomRead = $this->facadeImpl->createRoom($contract, $this->user->getId());

        $this->assertInstanceOf(RoomRead::class, $roomRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutRooms = User::factory()->create();

        $this->facadeImpl = resolve(RoomFacade::class);
    }
}
