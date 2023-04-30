<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Punishment>
 */
class PunishmentFactory extends Factory
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
            'punishment' => fake()->sentence(),
            'use_count' => fake()->randomDigit(),
            'language_id' => Language::firstOrFail()->getId(),
        ];
    }
}
