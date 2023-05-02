<?php

namespace Tests\Smoke\Component\Punishment\Infrastructure\Http\Controller;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\User;
use Tests\Smoke\SmokeTestCase;

class PunishmentControllerTest extends SmokeTestCase
{
    public function test_GetAllPunishments(): void
    {
        $user = User::factory()->create();
        Punishment::factory(10)->create(['user_id' => $user->getId()]);

        $response = $this->actingAs($user, "api")->json(
            "GET",
            route("user.punishments"),
            [
                "user" => $user->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddPunishment(): void
    {
        $user = User::factory()->create();
        $punishment = $this->faker->sentence();

        /** @var Language $language */
        $language = Language::firstOrFail();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.punishments.add"),
            [
                "user" => $user->getId(),
                "punishment" => $punishment,
                "language_id" => $language->getId(),
            ]
        );
        $response->assertStatus(200);
    }
}
