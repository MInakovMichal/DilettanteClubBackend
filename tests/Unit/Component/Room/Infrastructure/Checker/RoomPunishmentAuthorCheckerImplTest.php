<?php

namespace Tests\Unit\Component\Room\Infrastructure\Checker;

use App\Models\Punishment;
use App\Models\User;
use Common\Exception\InvalidArgumentException;
use Component\Room\Infrastructure\Checker\RoomPunishmentAuthorChecker;
use Tests\TestCase;

class RoomPunishmentAuthorCheckerImplTest extends TestCase
{
    private RoomPunishmentAuthorChecker $checker;
    private Punishment $punishment;

    public function test_Check_ShouldThrowInvalidArgumentException_WhenFindPunishmentFromAnotherUser(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $newUser = User::factory()->create();
        $this->checker->check($this->punishment->getId(), $newUser->getId());
    }

    public function test_Check_ShouldDoNothing_WhenFindOwnPunishment(): void
    {
        $this->assertNull($this->checker->check($this->punishment->getId(), $this->user->getId()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->punishment = Punishment::factory()->create(['user_id' => $this->user->getId()]);

        $this->checker = app(RoomPunishmentAuthorChecker::class);
    }
}
