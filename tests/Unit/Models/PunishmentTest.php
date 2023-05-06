<?php

namespace Tests\Unit\Models;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Tests\TestCase;

class PunishmentTest extends TestCase
{
    private Punishment $punishment;

    private int $id;

    private string $punishmentValue;

    private int $useCount;

    private Language $language;
    private User $user;

    public function test_GetId_ShouldReturnId(): void
    {
        $this->assertSame($this->id, $this->punishment->getId());
    }

    public function test_GetUserId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->user->getId(), $this->punishment->getUserId());
    }

    public function test_GetPunishment_ShouldReturnQuestion(): void
    {
        $this->assertSame($this->punishmentValue, $this->punishment->getPunishment());
    }

    public function test_GetUseCount_ShouldReturnCount(): void
    {
        $this->assertSame($this->useCount, $this->punishment->getUseCount());
    }

    public function test_GetLanguageId_ShouldReturnLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->punishment->getLanguageId());
    }

    public function test_SetPunishment_ShouldChangePunishmentValue(): void
    {
        $newPunishmentValue = $this->faker->sentence();

        $this->punishment->setPunishment($newPunishmentValue);
        $this->assertSame($newPunishmentValue, $this->punishment->getPunishment());
    }

    public function test_SetUserId_ShouldChangeUserId(): void
    {
        $newUser = User::factory()->make(['id' => $this->user->getId() + 1]);

        $this->punishment->setUserId($newUser->getId());
        $this->assertSame($newUser->getId(), $this->punishment->getUserId());
    }

    public function test_SetUseCount_ShouldChangeUseCount(): void
    {
        $newUseCount = $this->faker->randomDigit();

        $this->punishment->setUseCount($newUseCount);
        $this->assertSame($newUseCount, $this->punishment->getUseCount());
    }

    public function test_SetLanguageId_ShouldChangeLanguageId(): void
    {
        $newLanguage = Language::where('id', '!=', $this->language->getId())->firstOrFail();

        $this->punishment->setLanguageId($newLanguage->getId());
        $this->assertSame($newLanguage->getId(), $this->punishment->getLanguageId());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->id = 1;
        $this->punishmentValue = $this->faker()->sentence();
        $this->useCount = $this->faker->randomDigit();
        $this->language = Language::firstOrFail();
        $this->punishment = Punishment::factory()->make([
            'id' => $this->id,
            'punishment' => $this->punishmentValue,
            'user_id' => $this->user->getId(),
            'use_count' => $this->useCount,
            'language_id' => $this->language->getId()
        ]);
    }

}
