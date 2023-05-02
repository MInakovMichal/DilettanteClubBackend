<?php

namespace Tests\Unit\Component\Punishment\Infrastructure\Repository;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Component\Punishment\Infrastructure\Http\Requests\AddPunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\GetPunishmentsRequest;
use Component\Punishment\Infrastructure\Repository\PunishmentEntityRepository;
use Tests\TestCase;

class PunishmentEntityRepositoryImplTest extends TestCase
{
    private PunishmentEntityRepository $repositoryImpl;

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

        $punishments = $this->repositoryImpl->getAllPunishments($contract);

        $this->assertSame($punishmentsCount, $punishments->count());
    }

    public function test_GetAllPunishments_ShouldReturnEmptyArray_WhenUserHasNoPunishments(): void
    {
        $contract = new GetPunishmentsRequest([
            'user' => $this->userWithoutPunishments->getId()
        ]);

        $punishments = $this->repositoryImpl->getAllPunishments($contract);

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

        $punishmentRead = $this->repositoryImpl->addPunishment($contract);

        $this->assertInstanceOf(Punishment::class, $punishmentRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutPunishments = User::factory()->create();

        $this->repositoryImpl = resolve(PunishmentEntityRepository::class);
    }
}
