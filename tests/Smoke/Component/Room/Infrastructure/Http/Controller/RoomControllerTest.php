<?php

namespace Tests\Smoke\Component\Room\Infrastructure\Http\Controller;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\Question;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    public function test_GetAllQuestions(): void
    {
        $user = User::factory()->create();

        /** @var Language $language */
        $language = Language::firstOrFail();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.room.create"),
            [
                "name" => $this->faker->name(),
                "language_id" => $language->getId(),
                "is_private" => true,
                "password" => 'Password123#',
                "password_confirmation" => 'Password123#'
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddQuestionsToRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['author_id' => $user->getId()]);

        /** @var Collection $questions */
        $questions = Question::factory(10)->create();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.room.addQuestions"),
            [
                "questions" => $questions->pluck('id'),
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddPunishmentsToRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['author_id' => $user->getId()]);

        /** @var Collection $punishments */
        $punishments = Punishment::factory(10)->create();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.room.addPunishments"),
            [
                "punishments" => $punishments->pluck('id'),
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_UsersInRoom(): void
    {
        $user = User::factory()->create();
        $password = 'Password123#';
        $room = Room::factory()->create(['author_id' => $user->getId(), 'password' => Hash::make($password)]);

        $usersCount = 10;
        RoomUser::factory($usersCount)->create([
            'room_id' => $room->getId()
        ]);

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.room.usersInRoom"),
            [
                "password" => $password,
                "is_private" => true,
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }
}
