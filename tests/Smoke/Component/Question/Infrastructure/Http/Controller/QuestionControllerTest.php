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
            route("user.questions"),
            [
                "user" => $user->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddAllQuestion(): void
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
                "user" => $user->getId(),
                "question" => $question,
                "answer" => $answer,
                "language_id" => $language->getId(),
            ]
        );

        $response->assertStatus(200);
    }
}
