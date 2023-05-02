<?php

namespace Tests\Unit\Component\Question\Sdk\Model;

use App\Models\Language;
use App\Models\User;
use Component\Question\Sdk\Model\QuestionRead;
use Tests\TestCase;

class QuestionReadTest extends TestCase
{
    private QuestionRead $questionReadModel;
    private int $id;
    private string $questionValue;
    private int $answer;
    private int $useCount;
    private Language $language;
    private User $user;

    public function test_GetId_ShouldReturnQuestionId(): void
    {
        $this->assertSame($this->id, $this->questionReadModel->getId());
    }

    public function test_GetQuestion_ShouldReturnQuestion(): void
    {
        $this->assertSame($this->questionValue, $this->questionReadModel->getQuestion());
    }

    public function test_GetAnswer_ShouldReturnQuestionAnswer(): void
    {
        $this->assertSame($this->answer, $this->questionReadModel->getAnswer());
    }

    public function test_GetUseCount_ShouldReturnQuestionUseCount(): void
    {
        $this->assertSame($this->useCount, $this->questionReadModel->getUseCount());
    }

    public function test_GetLanguageId_ShouldReturnQuestionLanguageId(): void
    {
        $this->assertSame($this->language->getId(), $this->questionReadModel->getLanguageId());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->user = User::factory()->create();
        $this->questionValue = $this->faker->sentence();
        $this->answer = $this->faker->randomDigit();
        $this->useCount = $this->faker->randomDigit();
        $this->language = Language::firstOrFail();

        $this->questionReadModel = new QuestionRead(
            $this->id,
            $this->user->getId(),
            $this->questionValue,
            $this->answer,
            $this->useCount,
            $this->language->getId()
        );
    }
}
