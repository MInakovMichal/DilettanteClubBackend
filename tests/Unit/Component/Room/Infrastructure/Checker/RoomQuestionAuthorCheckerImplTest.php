<?php

namespace Tests\Unit\Component\Room\Infrastructure\Checker;

use App\Models\Question;
use App\Models\User;
use Common\Exception\InvalidArgumentException;
use Component\Room\Infrastructure\Checker\RoomQuestionAuthorChecker;
use Tests\TestCase;

class RoomQuestionAuthorCheckerImplTest extends TestCase
{
    private RoomQuestionAuthorChecker $checker;
    private Question $question;

    public function test_Check_ShouldThrowInvalidArgumentException_WhenFindQuestionFromAnotherUser(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $newUser = User::factory()->create();
        $this->checker->check($this->question->getId(), $newUser->getId());
    }

    public function test_Check_ShouldDoNothing_WhenFindOwnQuestion(): void
    {
        $this->assertNull($this->checker->check($this->question->getId(), $this->user->getId()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->question = Question::factory()->create(['user_id' => $this->user->getId()]);

        $this->checker = app(RoomQuestionAuthorChecker::class);
    }
}
