<?php

namespace Tests\Smoke\Component\Question\Infrastructure\Http\Controller;

use App\Models\Language;
use App\Models\Question;
use App\Models\User;
use Tests\Smoke\SmokeTestCase;

class QuestionControllerTest extends SmokeTestCase
{
    public function test_GetAllQuestions(): void
    {
        $user = User::factory()->create();
        Question::factory(10)->create(['user_id' => $user->getId()]);

        $response = $this->actingAs($user, "api")->json(
            "GET",
            route("user.questions.all"),
            [
                "user" => $user->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddQuestion(): void
    {
        $user = User::factory()->create();
        $question = $this->faker->sentence();
        $answer = $this->faker->randomDigit();

        /** @var Language $language */
        $language = Language::firstOrFail();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.questions.add"),
            [
                "question" => $question,
                "answer" => $answer,
                "language_id" => $language->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_DeleteQuestion(): void
    {
        $user = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->getId()]);

        $response = $this->actingAs($user, "api")->json(
            "DELETE",
            route("user.questions.delete"),
            [
                "id" => $question->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_UpdateQuestion(): void
    {
        $oldQuestionValue = $this->faker->sentence();
        $newQuestionValue = $this->faker->sentence();
        $oldAnswer = $this->faker->randomDigit();
        $newAnswer = $this->faker->randomDigit();
        /** @var Language $language */
        $language = Language::firstOrFail();

        $user = User::factory()->create();
        $question = Question::factory()->create([
            'user_id' => $user->getId(),
            'question' => $oldQuestionValue,
            'answer' => $oldAnswer
        ]);

        $response = $this->actingAs($user, "api")->json(
            "PUT",
            route("user.questions.update"),
            [
                "id" => $question->getId(),
                "question" => $newQuestionValue,
                "answer" => $newAnswer,
                "language_id" => $language->getId(),
            ]
        );

        $response->assertStatus(200);
    }
}
