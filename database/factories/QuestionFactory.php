<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Language;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'question' => fake()->sentence(),
            'answer_id' => Answer::factory(),
            'use_count' => fake()->randomDigit(),
            'language_id' => Language::firstOrFail()->getId(),
        ];
    }
}
