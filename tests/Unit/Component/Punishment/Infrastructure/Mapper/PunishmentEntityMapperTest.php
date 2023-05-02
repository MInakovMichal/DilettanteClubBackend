<?php

namespace Tests\Unit\Component\Punishment\Infrastructure\Mapper;

use App\Models\Punishment;
use Component\Punishment\Infrastructure\Mapper\PunishmentEntityMapper;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Tests\TestCase;

class PunishmentEntityMapperTest extends TestCase
{
    private PunishmentEntityMapper $mapper;

    public function test_MapToReadModel_ShouldReturnPunishmentReadModel()
    {
        $punishment = Punishment::factory()->make(['id' => 1]);
        $response = $this->mapper->mapToReadModel($punishment);
        $this->assertInstanceOf(PunishmentRead::class, $response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = resolve(PunishmentEntityMapper::class);
    }
}
