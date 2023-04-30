<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Models\User;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    private Answer $answer;

    private int $id;

    private string $answerValue;

    private User $user;

    public function test_GetId_ShouldReturnAnswerId(): void
    {
        $this->assertSame($this->id, $this->answer->getId());
    }

    public function test_GetUserId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->user->getId(), $this->answer->getUserId());
    }

    public function test_GetAnswer_ShouldReturnAnswer(): void
    {
        $this->assertSame($this->answerValue, $this->answer->getAnswer());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->id = 1;
        $this->answerValue = 'test code';
        $this->answer = Answer::factory()->make(['id' => $this->id, 'answer' => $this->answerValue, 'user_id' => $this->user->getId()]);
    }
}
