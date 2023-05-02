<?php

namespace Tests\Unit\Component\Punishment\Infrastructure\Service;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Component\Punishment\Infrastructure\Http\Requests\AddPunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\GetPunishmentsRequest;
use Component\Punishment\Infrastructure\Service\PunishmentService;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Tests\TestCase;

class PunishmentServiceImplTest extends TestCase
{
    private PunishmentService $serviceImpl;

    private User $user;

    public function test_GetAllPunishments_ShouldReturnArrayWithTenElements_WhenUserHasPunishments(): void
    {
        $punishmentsCount = 10;
        Punishment::factory($punishmentsCount)->create([
            'user_id' => $this->user->getId()
        ]);

        $contract = new GetPunishmentsRequest([
            'user' => $this->user->getId()
        ]);

        $punishments = $this->serviceImpl->getAllPunishments($contract);

        $this->assertSame($punishmentsCount, $punishments->count());
    }

    public function test_GetAllPunishments_ShouldReturnEmptyArray_WhenUserHasNoPunishments(): void
    {
        $contract = new GetPunishmentsRequest([
            'user' => $this->userWithoutPunishments->getId()
        ]);

        $punishments = $this->serviceImpl->getAllPunishments($contract);

        $this->assertSame(0, $punishments->count());
    }

    public function test_AddPunishment_ShouldReturnPunishmentReadClass_WhenUserAddPunishment(): void
    {
        $punishmentValue = $this->faker->sentence();
        $language = Language::firstOrFail();

        $contract = new AddPunishmentRequest([
            'user' => $this->userWithoutPunishments->getId(),
            'punishment' => $punishmentValue,
            'language_id' => $language->getId()
        ]);

        $punishmentRead = $this->serviceImpl->addPunishment($contract);

        $this->assertInstanceOf(PunishmentRead::class, $punishmentRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutPunishments = User::factory()->create();

        $this->serviceImpl = resolve(PunishmentService::class);
    }
}
