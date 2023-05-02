<?php

namespace Tests\Unit\Component\Punishment\Sdk\Model;

use App\Models\Language;
use App\Models\User;
use Component\Punishment\Sdk\Model\PunishmentRead;
use Tests\TestCase;

class PunishmentReadTest extends TestCase
{
    private PunishmentRead $punishmentRead;
    private int $id;
    private string $punishmentValue;
    private int $useCount;
    private Language $language;
    private User $user;

    public function test_GetId_ShouldReturnQuestionId(): void
    {
        $this->assertSame($this->id, $this->punishmentRead->getId());
    }

    public function test_GetPunishment_ShouldReturnPunishment(): void
    {
        $this->assertSame($this->punishmentValue, $this->punishmentRead->getPunishment());
    }

    public function test_GetUseCount_ShouldReturnQuestionUseCount(): void
    {
        $this->assertSame($this->useCount, $this->punishmentRead->getUseCount());
    }

    public function test_GetLanguageId_ShouldReturnQuestionLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->punishmentRead->getLanguageId());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->user = User::factory()->create();
        $this->punishmentValue = $this->faker->sentence();
        $this->useCount = $this->faker->randomDigit();
        $this->language = Language::firstOrFail();

        $this->punishmentRead = new PunishmentRead(
            $this->id,
            $this->user->getId(),
            $this->punishmentValue,
            $this->useCount,
            $this->language->getId()
        );
    }
}
