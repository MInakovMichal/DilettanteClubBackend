<?php

namespace Tests\Unit\Component\Question\Domain;

use App\Models\Language;
use App\Models\Question;
use App\Models\User;
use Common\Exception\UnauthorizedException;
use Component\Question\Infrastructure\Http\Requests\AddQuestionRequest;
use Component\Question\Infrastructure\Http\Requests\DeleteQuestionRequest;
use Component\Question\Infrastructure\Http\Requests\GetQuestionsRequest;
use Component\Question\Infrastructure\Http\Requests\UpdateQuestionRequest;
use Component\Question\Sdk\Model\QuestionRead;
use Component\Question\Sdk\QuestionFacade;
use Tests\TestCase;

class QuestionFacadeImplTest extends TestCase
{
    private QuestionFacade $facadeImpl;

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

        $questions = $this->facadeImpl->getAllQuestions($contract);

        $this->assertSame($questionsCount, $questions->count());
    }

    public function test_GetAllQuestions_ShouldReturnEmptyArray_WhenUserHasNoQuestions(): void
    {
        $contract = new GetQuestionsRequest([
            'user' => $this->userWithoutQuestions->getId()
        ]);

        $questions = $this->facadeImpl->getAllQuestions($contract);

        $this->assertSame(0, $questions->count());
    }

    public function test_AddQuestion_ShouldReturnQuestionReadClass_WhenUserAddQuestion(): void
    {
        $questionValue = $this->faker->sentence();
        $answer = $this->faker->randomDigit();
        $language = Language::firstOrFail();

        $contract = new AddQuestionRequest([
            'question' => $questionValue,
            'answer' => $answer,
            'language_id' => $language->getId()
        ]);

        $questionRead = $this->facadeImpl->addQuestion($contract, $this->user->getId());

        $this->assertInstanceOf(QuestionRead::class, $questionRead);
    }

    public function test_DeleteQuestion_ShouldDeleteQuestion(): void
    {
        $question = Question::factory()->create([
            'user_id' => $this->user->getId()
        ]);

        $contract = new DeleteQuestionRequest([
            'id' => $question->getId(),
        ]);

        $questionsBeforeDelete = Question::all()->count();
        $this->facadeImpl->deleteQuestion($contract, $this->user->getId());
        $questionsAfterDelete = Question::all()->count();

        $this->assertSame($questionsBeforeDelete - 1, $questionsAfterDelete);
    }

    public function test_DeleteQuestion_ShouldThrowUnauthorizedRequest_WhetTryToDeleteNotOwnQuestion(): void
    {
        $this->expectException(UnauthorizedException::class);

        /** @var Question $question */
        $question = Question::factory()->create();

        $contract = new DeleteQuestionRequest([
            'id' => $question->getId(),
        ]);

        $this->facadeImpl->deleteQuestion($contract, $this->user->getId());
    }

    public function test_UpdateQuestion_ShouldThrowUnauthorizedRequest_WhetTryToUpdateNotOwnQuestion(): void
    {
        $this->expectException(UnauthorizedException::class);

        /** @var Question $question */
        $question = Question::factory()->create();

        $contract = new UpdateQuestionRequest([
            'id' => $question->getId(),
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->randomDigit(),
            'language_id' => $question->getLanguageId(),
        ]);

        $this->facadeImpl->updateQuestion($contract, $this->user->getId());
    }

    public function test_UpdateQuestion_ShouldReturnQuestionReadClassWithNewData_WhenUserUpdateOwnQuestion(): void
    {
        $oldQuestionValue = $this->faker->sentence();
        $newQuestionValue = $this->faker->sentence();
        $oldAnswer = $this->faker->randomDigit();
        $newAnswer = $this->faker->randomDigit();
        /** @var Language $language */
        $language = Language::firstOrFail();

        $question = Question::factory()->create([
            'user_id' => $this->user->getId(),
            'question' => $oldQuestionValue,
            'answer' => $oldAnswer
        ]);

        $contract = new UpdateQuestionRequest([
            'id' => $question->getId(),
            "question" => $newQuestionValue,
            "answer" => $newAnswer,
            "language_id" => $language->getId(),
        ]);

        $questionRead = $this->facadeImpl->updateQuestion($contract, $this->user->getId());

        $this->assertInstanceOf(QuestionRead::class, $questionRead);
        $this->assertSame($newQuestionValue, $questionRead->getQuestion());
        $this->assertSame($newAnswer, $questionRead->getAnswer());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userWithoutQuestions = User::factory()->create();

        $this->facadeImpl = resolve(QuestionFacade::class);
    }
}
