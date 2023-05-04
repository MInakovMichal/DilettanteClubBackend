<?php

namespace Tests\Unit\Component\Punishment\Domain;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Common\Exception\UnauthorizedException;
use Component\Punishment\Infrastructure\Http\Requests\AddPunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\GetPunishmentsRequest;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Component\Punishment\Sdk\PunishmentFacade;
use Component\Punishment\Infrastructure\Http\Requests\DeletePunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\UpdatePunishmentRequest;
use Tests\TestCase;

class PunishmentFacadeImplTest extends TestCase
{
    private PunishmentFacade $facadeImpl;

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

        $punishments = $this->facadeImpl->getAllPunishments($contract);

        $this->assertSame($punishmentsCount, $punishments->count());
    }

    public function test_GetAllPunishments_ShouldReturnEmptyArray_WhenUserHasNoPunishments(): void
    {
        $contract = new GetPunishmentsRequest([
            'user' => $this->userWithoutPunishments->getId()
        ]);

        $punishments = $this->facadeImpl->getAllPunishments($contract);

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

        $punishmentRead = $this->facadeImpl->addPunishment($contract, $this->user->getId());

        $this->assertInstanceOf(PunishmentRead::class, $punishmentRead);
    }

    public function test_DeletePunishment_ShouldDeletePunishment(): void
    {
        $Punishment = Punishment::factory()->create([
            'user_id' => $this->user->getId()
        ]);

        $contract = new DeletePunishmentRequest([
            'id' => $Punishment->getId(),
        ]);

        $PunishmentsBeforeDelete = Punishment::all()->count();
        $this->facadeImpl->deletePunishment($contract, $this->user->getId());
        $PunishmentsAfterDelete = Punishment::all()->count();

        $this->assertSame($PunishmentsBeforeDelete - 1, $PunishmentsAfterDelete);
    }

    public function test_DeletePunishment_ShouldThrowUnauthorizedRequest_WhetTryToDeleteNotOwnPunishment(): void
    {
        $this->expectException(UnauthorizedException::class);

        /** @var Punishment $punishment */
        $punishment = Punishment::factory()->create();

        $contract = new DeletePunishmentRequest([
            'id' => $punishment->getId(),
        ]);

        $this->facadeImpl->deletePunishment($contract, $this->user->getId());
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

        $this->facadeImpl->updatePunishment($contract, $this->user->getId());
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

        $punishmentRead = $this->facadeImpl->updatePunishment($contract, $this->user->getId());

        $this->assertInstanceOf(PunishmentRead::class, $punishmentRead);
        $this->assertSame($newPunishmentValue, $punishmentRead->getPunishment());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutPunishments = User::factory()->create();

        $this->facadeImpl = resolve(PunishmentFacade::class);
    }
}
