<?php

namespace Tests\Unit\Component\Question\Infrastructure\Repository;

use App\Models\Language;
use App\Models\Question;
use App\Models\User;
use Component\Question\Infrastructure\Http\Requests\AddQuestionRequest;
use Component\Question\Infrastructure\Http\Requests\GetQuestionsRequest;
use Component\Question\Infrastructure\Repository\QuestionEntityRepository;
use Tests\TestCase;

class QuestionEntityRepositoryImplTest extends TestCase
{
    private QuestionEntityRepository $repositoryImpl;

    private User $user;

    public function test_GetAllQuestions_ShouldReturnArrayWithTenElements_WhenUserHasQuestions(): void
    {
        $questionsCount = 10;
        Question::factory($questionsCount)->create([
            'user_id' => $this->user->getId()
        ]);

        $contract = new GetQuestionsRequest([
            'user' => $this->user->getId()
        ]);

        $questions = $this->repositoryImpl->getAllQuestions($contract);

        $this->assertSame($questionsCount, $questions->count());
    }

    public function test_GetAllQuestions_ShouldReturnEmptyArray_WhenUserHasNoQuestions(): void
    {
        $contract = new GetQuestionsRequest([
            'user' => $this->userWithoutQuestions->getId()
        ]);

        $questions = $this->repositoryImpl->getAllQuestions($contract);

        $this->assertSame(0, $questions->count());
    }

    public function test_AddQuestion_ShouldReturnQuestionReadClass_WhenUserAddQuestion(): void
    {
        $questionValue = $this->faker->sentence();
        $answer = $this->faker->randomDigit();
        $language = Language::firstOrFail();

        $contract = new AddQuestionRequest([
            'user' => $this->userWithoutQuestions->getId(),
            'question' => $questionValue,
            'answer' => $answer,
            'language_id' => $language->getId()
        ]);

        $questionRead = $this->repositoryImpl->addQuestion($contract);

        $this->assertInstanceOf(Question::class, $questionRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutQuestions = User::factory()->create();

        $this->repositoryImpl = resolve(QuestionEntityRepository::class);
    }
}
