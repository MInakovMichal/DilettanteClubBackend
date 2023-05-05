<?php

namespace Tests\Unit\Component\Room\Infrastructure\Mapper;

use App\Models\Room;
use Component\Room\Infrastructure\Mapper\RoomEntityMapper;
use Component\Room\Sdk\Model\RoomRead;
use Tests\TestCase;

class RoomEntityMapperTest extends TestCase
{
    private RoomEntityMapper $mapper;

    public function test_MapToReadModel_ShouldReturnRoomReadModel()
    {
        $room = Room::factory()->make(['id' => 1]);
        $response = $this->mapper->mapToReadModel($room);
        $this->assertInstanceOf(RoomRead::class, $response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = resolve(RoomEntityMapper::class);
    }
}
