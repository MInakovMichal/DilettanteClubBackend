<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Models\Language;
use App\Models\Question;
use App\Models\User;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    private Question $question;

    private int $id;

    private string $questionValue;

    private int $useCount;

    private Language $language;
    private int $answer;
    private User $user;

    public function test_GetId_ShouldReturnId(): void
    {
        $this->assertSame($this->id, $this->question->getId());
    }

    public function test_GetUserId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->user->getId(), $this->question->getUserId());
    }

    public function test_GetQuestion_ShouldReturnQuestion(): void
    {
        $this->assertSame($this->questionValue, $this->question->getQuestion());
    }

    public function test_GetAnswerId_ShouldReturnAnswerId(): void
    {
        $this->assertSame($this->answer, $this->question->getAnswer());
    }

    public function test_GetUseCount_ShouldReturnCount(): void
    {
        $this->assertSame($this->useCount, $this->question->getUseCount());
    }

    public function test_GetLanguageId_ShouldReturnLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->question->getLanguageId());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->id = 1;
        $this->questionValue = $this->faker()->sentence();
        $this->useCount = $this->faker->randomDigit();
        $this->language = Language::firstOrFail();
        $this->answer = $this->faker->randomDigit();
        $this->question = Question::factory()->make([
            'id' => $this->id,
            'question' => $this->questionValue,
            'user_id' => $this->user->getId(),
            'answer' => $this->answer,
            'use_count' => $this->useCount,
            'language_id' => $this->language->getId()
        ]);
    }
}
