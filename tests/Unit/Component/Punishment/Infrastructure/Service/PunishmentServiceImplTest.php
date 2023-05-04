<?php

namespace Tests\Unit\Component\Punishment\Infrastructure\Service;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Common\Exception\UnauthorizedException;
use Component\Punishment\Infrastructure\Http\Requests\AddPunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\DeletePunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\GetPunishmentsRequest;
use Component\Punishment\Infrastructure\Http\Requests\UpdatePunishmentRequest;
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
            'punishment' => $punishmentValue,
            'language_id' => $language->getId()
        ]);

        $punishmentRead = $this->serviceImpl->addPunishment($contract, $this->user->getId());

        $this->assertInstanceOf(PunishmentRead::class, $punishmentRead);
    }

    public function test_DeletePunishment_ShouldDeletePunishment(): void
    {
        $punishment = Punishment::factory()->create([
            'user_id' => $this->user->getId()
        ]);

        $contract = new DeletePunishmentRequest([
            'id' => $punishment->getId(),
        ]);

        $punishmentsBeforeDelete = Punishment::all()->count();
        $this->serviceImpl->deletePunishment($contract, $this->user->getId());
        $punishmentsAfterDelete = Punishment::all()->count();

        $this->assertSame($punishmentsBeforeDelete - 1, $punishmentsAfterDelete);
    }

    public function test_DeletePunishment_ShouldThrowUnauthorizedRequest_WhetTryToDeleteNotOwnPunishment(): void
    {
        $this->expectException(UnauthorizedException::class);

        /** @var Punishment $punishment */
        $punishment = Punishment::factory()->create();

        $contract = new DeletePunishmentRequest([
            'id' => $punishment->getId(),
        ]);

        $this->serviceImpl->deletePunishment($contract, $this->user->getId());
    }

    public function test_UpdatePunishment_ShouldThrowUnauthorizedRequest_WhetTryToUpdateNotOwnPunishment(): void
    {
        $this->expectException(UnauthorizedException::class);

        /** @var Punishment $punishment */
        $punishment = Punishment::factory()->create();

        $contract = new UpdatePunishmentRequest([
            'id' => $punishment->getId(),
            'punishment' => $this->faker->sentence(),
            'answer' => $this->faker->randomDigit(),
            'language_id' => $punishment->getLanguageId(),
        ]);

        $this->serviceImpl->updatePunishment($contract, $this->user->getId());
    }

    public function test_UpdatePunishment_ShouldReturnPunishmentReadClassWithNewData_WhenUserUpdateOwnPunishment(): void
    {
        $oldPunishmentValue = $this->faker->sentence();
        $newPunishmentValue = $this->faker->sentence();
        /** @var Language $language */
        $language = Language::firstOrFail();

        $punishment = Punishment::factory()->create([
            'user_id' => $this->user->getId(),
            'punishment' => $oldPunishmentValue,
        ]);

        $contract = new UpdatePunishmentRequest([
            'id' => $punishment->getId(),
            "punishment" => $newPunishmentValue,
            "language_id" => $language->getId(),
        ]);

        $punishmentRead = $this->serviceImpl->updatePunishment($contract, $this->user->getId());

        $this->assertInstanceOf(PunishmentRead::class, $punishmentRead);
        $this->assertSame($newPunishmentValue, $punishmentRead->getPunishment());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutPunishments = User::factory()->create();

        $this->serviceImpl = resolve(PunishmentService::class);
    }
}
